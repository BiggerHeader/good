<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $userService;

    /**
     * LoginController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
//        $this->middleware('guest')->except('logout');

        $this->userService = $userService;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Multiple logon failed lock
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // auth user
        if ($this->attemptLogin($request)) {

            // Gets the currently logged in user
            $user = $this->guard()->user();

            // If the user is not activated
            if ($user->is_active != 1) {
                Auth::logout();

                // Get activation link and alert
                $link = $this->userService->getActiveLink($user);
                return redirect('login')->withInput()->withErrors([$this->username() => $link]);
            }

            //添加最近登录 的用户到  Redis 里面   以显示活跃用户
            $redis = new  \Redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->auth('');
            //获取队列长度
            if ($redis->lLen('active_user_list') > 10) {
                //删除 列表中多余数据
                $redis->lTrim('active_user_list', 11, -1);
            }

            $redis->lPush('active_user_list', json_encode($user->toArray(), JSON_UNESCAPED_UNICODE));

            return $this->sendLoginResponse($request);
        }

        // if the login attempt is not successful, we will increase the number of
        // login and redirect users to the login form. Of course, when this
        // users who exceed their maximum number of attempts, they will be locked.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * After login (increase login time)
     * @param Request $request
     * @param $user
     */
    protected function authenticated(Request $request, $user)
    {
        //
        $user->increment('login_count');
    }


    /**
     * Is there a jump URL before login
     * @return string
     */
    public function redirectTo()
    {
        return request()->has('redirect_url') ? request()->input('redirect_url') : '/';
    }

    /**
     * rewrite credentials, Enable login by mail or user name
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $field => $request->input($this->username()),
            'password' => $request->input('password')
        ];
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => '账号不能为空',
            $this->username() . '.string' => '账号必须是正确的字符串',
            'password.required' => '密码不能为空'
        ]);
    }

    public function username()
    {
        return 'account';
    }
}
