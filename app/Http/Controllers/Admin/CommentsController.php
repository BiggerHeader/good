<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 2018/3/17
 * Time: 16:15
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function index()
    {

        return view('admin.comments.index');
    }

    public function feedback()
    {
        return view('admin.comments.feedback');
    }


}