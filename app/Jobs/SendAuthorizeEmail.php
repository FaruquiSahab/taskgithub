<?php

namespace App\Jobs;


use Log;
use Redis;
use Crypt;
use App\RedisJob;
use App\RedisPivot;
use Webpatser\Uuid\Uuid;
use Faker\Generator as Faker;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAuthorizeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $name;
    private $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Faker $faker)
    {

        for($i = 0; $i < 1000; $i++) {
            $redis = new RedisJob;
                $redis->column1   =   Uuid::generate()->string;
                $redis->column2   =   Uuid::generate(3,'value', Uuid::NS_DNS);
                $redis->column3   =   Uuid::generate(5,'value', Uuid::NS_DNS); ;
                $redis->column4   =   \Carbon\Carbon::now()->addDays($i);
                $redis->column5   =   $faker->paragraph ;
                $redis->column6   =   mt_rand(100,1000) ;
                $redis->column7   =   Crypt::encrypt(mt_rand(100,1000)) ;
                $redis->column8   =   '1' ;
            $redis->save();
            $pivot = new RedisPivot;
            $pivot->redis_jobs_id = $redis->id;
            $pivot->save();
        }
    }
}
