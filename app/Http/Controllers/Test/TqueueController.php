<?php

namespace App\Http\Controllers\Test;

use App\Jobs\SendReminderEmail;
use App\Mail\SubscribesNotice;
use App\Models\Product;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TqueueController extends Controller
{

    public function index(Request $request)
    {
        /*$path = base_path( 'storage/logs/queue.txt');
        echo $path;
        var_dump( file_exists($path));*/
        //吧 这个请求  分配到 对应的队列中
        /*error_log('cccc', 3, base_path('storage/logs/laravel.log'));

        dispatch(new SendReminderEmail(new SubscribesNotice()));*/
    }

}



