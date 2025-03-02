<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->boolean('create_comment');
            $table->boolean('create_article');
            $table->boolean('create_role');
            $table->boolean('create_user');
            $table->boolean('edit_comment');
            $table->boolean('edit_article');
            $table->boolean('edit_role');
            $table->boolean('edit_user');
            $table->boolean('delete_comment');
            $table->boolean('delete_article');
            $table->boolean('delete_role');
            $table->boolean('delete_user');
            $table->boolean('invite_author');
            $table->boolean('revoke_author');
            $table->boolean('schedule_article');
            $table->boolean('run_article');
            $table->boolean('view_pending');
            $table->boolean('permalink');
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
        Schema::dropIfExists('roles');
    }
}
