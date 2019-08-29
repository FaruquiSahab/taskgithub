<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableRedisJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redis_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('column1')->nullable();
            $table->longText('column2')->nullable();
            $table->longText('column3')->nullable();
            $table->longText('column4')->nullable();
            $table->longText('column5')->nullable();
            $table->longText('column6')->nullable();
            $table->longText('column7')->nullable();
            $table->longText('column8')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redis_jobs');
    }
}
