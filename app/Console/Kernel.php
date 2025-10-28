<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        // This array must include your custom command for Artisan to recognize it
        \App\Console\Commands\StasisCDRpopulate::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // // Daily report at 8pm
        // $schedule->call(function() {
        //     $report = new ReportController();
        //     $data = $report->calculateCallMetrics(Carbon::today(), Carbon::now());

        //     // Send email to recipients
        //     Mail::to(explode(',', config('reports.daily_recipients')))
        //         ->send(new DailyReportMail($data));
        // })->dailyAt('20:00');

        // // Weekly report every Monday at 8am
        // $schedule->call(function() {
        //     $report = new ReportController();
        //     $data = $report->calculateCallMetrics(
        //         Carbon::now()->startOfWeek(),
        //         Carbon::now()->endOfWeek()
        //     );

        //     Mail::to(explode(',', config('reports.weekly_recipients')))
        //         ->send(new WeeklyReportMail($data));
        // })->weeklyOn(1, '8:00');
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
