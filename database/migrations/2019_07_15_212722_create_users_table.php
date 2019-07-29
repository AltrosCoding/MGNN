<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name', 100)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->datetime('birth_date')->nullable();
            $table->string('email', 100)->unique();
            $table->boolean('is_confirmed')->default(false);
            $table->integer('exp')->default(0);
            $table->integer('level')->default(1);
            $table->string('ad_sense_snippet', 1000)->nullable();
        });

        DB::statement('ALTER TABLE users ADD password binary(60) NOT NULL AFTER user_name');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
