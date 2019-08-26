<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\PostSchedule;

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
        PostSchedule::where('scheduled_at', '<=', \Carbon\Carbon::now())
        ->get()
        ->each(function ($schedule) {
            $schedule->post()->update([
                'status' => 'published',
                'published_at' => \Carbon\Carbon::now(),
            ]);

            $schedule->delete();
        });
    }
}
