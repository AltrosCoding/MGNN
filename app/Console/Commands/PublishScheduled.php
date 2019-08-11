<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Post;

class PublishScheduled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Published all scheduled articles that are due';

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
        Post::whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', \Carbon\Carbon::now())
            ->where('status', '=', 'scheduled')
            ->update(['status' => 'published']);
    }
}
