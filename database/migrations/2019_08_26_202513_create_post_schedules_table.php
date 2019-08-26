<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('post_id')->nullable();
            $table->datetime('scheduled_at');

            $table->foreign('post_id')
                  ->references('id')->on('posts')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_schedules');
    }
}
