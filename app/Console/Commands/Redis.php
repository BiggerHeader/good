<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Redis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        ini_set('default_socket_timeout', -1);
        $redis = new  \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('');

        for ($i = ord('a'); $i <= ord('z'); $i++) {
            echo chr($i) . ' ' . $i . "\n";
        }

        var_dump(isset($null));
        $redis->subscribe(['leaning', 'redisChat'], function ($instance, $channelName, $message) {
            var_dump($instance, $channelName, $message);
        });
    }
}
