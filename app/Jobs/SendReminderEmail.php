<?php

namespace App\Jobs;

use App\Mail\SubscribesNotice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $obj;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SubscribesNotice $subscribesNotice)
    {
        //\
        $this->obj = $subscribesNotice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $time = date('Y-m-d H:i:s');

         echo  'swdfergyhjukilola' ;
        //
       // error_log('1234567', 3, base_path('storage/logs/laravel.log'));
    }
}
