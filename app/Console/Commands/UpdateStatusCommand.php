<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateStatusJob;
use App\RedisPivot;
use App\RedisJob;

class UpdateStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Every Minute To Check Any Update';

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
        UpdateStatusJob::dispatch();
    }
}
