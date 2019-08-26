<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePostsScheduling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            \App\Post::where('status', '=', 'scheduled')
            ->get()
            ->each(function ($post) {
                $post->schedule()->create([
                    'scheduled_at' => $post->scheduled_at,
                ]);
                $post->scheduled_at = null;
                $post->save();
            });
            $table->renameColumn('scheduled_at', 'published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            \App\Post::where('status', '=', 'scheduled')
            ->get()
            ->each(function ($post) {
                $post->published_at = $post->schedule()->scheduled_at;
                $post->schedule()->delete();
            });
            $table->renameColumn('published_at', 'scheduled_at');
        });
    }
}
