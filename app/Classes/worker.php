<?php
namespace App\Classes;


/*
 * This is a process that continuously listen work on the queue. You could call it a
 * "job listener " =)
 */
class worker
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
     * initialize constructor
     */
    public function __construct($hots, $port=5672, $username='guest', $password='guest')
    {
        $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection($host, $port, $username, $password);
        $this->connection = $connection;
        $this->channel();
    }

    /**
     * initialize connection channel
     */
    private function channel()
    {
        $channel = $connection->channel();
    }

    // Create the queue if it doesnt already exist.
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
        return ' [*] Waiting for messages. To exit press CTRL+C', "\n";
    }

    // Job Handle
    // Maybe Not This Just Worker Console 
    public function handle($msg)
    {
        return
        $callback = function($msg){
            echo " [x] Received ", $msg->body, "\n";
            $job = json_decode($msg->body, $assocForm=true);
            sleep($job['sleep_period']);
            echo " [x] Done", "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };
    }

    public function consume($queueName)
    {
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queue=$queueName, $consumer_tag='', $no_local=false, $no_ack=false, $exclusive=false, $nowait=false, $callback);
        while (count($channel->callbacks)) 
        {
            $channel->wait();
        }
    }

    public function close()
    {
        $channel->close();
        $connection->close();
    }


}

 












