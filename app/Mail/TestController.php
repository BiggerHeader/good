<?php
/**
 * Created by PhpStorm.
 * User: 140439
 * Date: 2018/3/19
 * Time: 18:55
 */

namespace App\Mail;


class TestController extends Mailable
{
    use Queueable, SerializesModels;
    protected  $subject = '测试队列';


}