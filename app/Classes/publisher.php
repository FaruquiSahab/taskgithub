<?php
namespace App\Classes;


use Crypt;
use App\RedisJob;
use App\RedisPivot;
use Webpatser\Uuid\Uuid;
use Faker\Generator as Faker;


/*
 * This is a process that continuously publishes work to the queue. You could call it a
 * "job creator" =)
 */
class publisher
{
    /**
     * class variable for connection
     */
    private $connection;

    /**
     * class variable for channel communication
     */
    private $channel;

    /**
     * initialize connection
     */
    public function __construct($host, $port=5672, $username='guest', $password='guest')
    {
        $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(host, port, username, password);
        $this->connection = $connection;
        $this->channel();
    }

    /**
     * initialize connection channel
     */
    private function channel()
    {
        $this->channel = $connection->channel()
    }

    /**
     * Create the queue if it doesn't already exist.
     */
    public function queue_declare($queueName)
    {
        $channel->queue_declare(
            $queue = $queueName,
            $passive = false,
            $durable = true,
            $exclusive = false,
            $auto_delete = false,
            $nowait = false,
            $arguments = null,
            $ticket = null
        );
    }

    //Laravel Dispatch 
    public function publish($queueName)
    {
        $job_id=0;
        // infinite loop for testing
        while (true)
        {
            $jobArray = array(
                'id' => $job_id++,
                'task' => 'sleep',
                'sleep_period' => rand(0, 3)
            );

            $redisjob = new RedisJob;
                $redis->column1   =   Uuid::generate()->string;
                $redis->column2   =   Uuid::generate(3,'value', Uuid::NS_DNS);
                $redis->column3   =   Uuid::generate(5,'value', Uuid::NS_DNS); ;
                $redis->column4   =   \Carbon\Carbon::now()->addDays($i);
                $redis->column5   =   $faker->paragraph ;
                $redis->column6   =   mt_rand(100,1000) ;
                $redis->column7   =   Crypt::encrypt(mt_rand(100,1000)) ;
                $redis->column8   =   '1' ;
            $redisjob->save();
            

            $msg = new \PhpAmqpLib\Message\AMQPMessage(
                json_encode($jobArray, JSON_UNESCAPED_SLASHES),
                array('delivery_mode' => 2) # make message persistent
            );

            $channel->basic_publish($msg, '', $queueName);
            print 'Job created: ' . $job_id . '' . PHP_EOL;
            sleep(1);
        }
    }
}






