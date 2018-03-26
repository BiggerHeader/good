<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 2018/3/25
 * Time: 22:56
 */

namespace App\Http\Controllers;


class OtherController extends BaseController
{
    public function webhook()
    {
        error_reporting(1);

        $target = '/data/wwwroot/default/test'; // 生产环境web目录

        $token = 'webhook';
        $wwwUser = 'www';
        $wwwGroup = 'www';

        $json = json_decode(file_get_contents('php://input'), true);

        if (empty($json['token']) || $json['token'] !== $token) {
            exit('error request');
        }

        $repo = $json['repository']['name'];

        $cmd = "cd $target && git pull";

        echo shell_exec($cmd);
    }
}