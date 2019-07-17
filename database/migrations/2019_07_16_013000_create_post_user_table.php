<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('post_id');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('post_user');
    }
}
