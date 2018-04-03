<?php
/**
 * Created by PhpStorm.
 * User: 140439
 * Date: 2018/4/3
 * Time: 16:11
 */

namespace App\Console\Commands;


class RedisTest
{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function handel()
    {

        ini_set('default_socket_timeout', -1);
        $redis = new  \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('');
        $redis->subscribe(['leaning', 'redisChat'], function ($instance, $channelName, $message) {
            echo $message;
        });
    }

}