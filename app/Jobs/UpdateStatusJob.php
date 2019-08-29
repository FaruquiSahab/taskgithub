<?php

namespace App\Jobs;

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

class UpdateStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $ids = RedisJob::where('column8','=',2)->limit(10000)->get('id');
        if($ids){
            $records = $ids->toArray();
        }
        if(!empty($records)){
            RedisJob::whereIn('id',$records)->update([
                'column1'   => Uuid::generate()->string,
                'column2'   => Uuid::generate(3,'value', Uuid::NS_DNS),
                'column3'   => Uuid::generate(5,'value', Uuid::NS_DNS),
                'column4'   => \Carbon\Carbon::now()->addDays(1),
                'column5'   => $faker->paragraph,
                'column6'   => mt_rand(100,1000),
                'column7'   => Crypt::encrypt(mt_rand(100,1000)),
                'column8'   => '1'
            ]);
            RedisPivot::whereIn('redis_jobs_id',$records)->update([
                'job_operation'=>'running'
            ]);

        }
    }
}
