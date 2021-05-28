<?php

namespace App\Console;

use App\Models\Question;
use App\Models\QuestionComment;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // after 1 minute call this method
        $schedule->call(function () {
            foreach (Question::all() as $question) {
                $c = QuestionComment::whereQuestionId($question->id)->get()->last();
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $c->created_at);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', now('+25 hours'));
                $seconds = $to->diffInSeconds($from);
                if ($seconds > 86400) {
                    $question->update(['status' => 1]);
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
