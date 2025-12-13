<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the application's Artisan commands.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // 🛠️ Retry failed jobs every 5 minutes
        $schedule->command('jobs:retry-failed')
            ->everyFiveMinutes()
            ->runInBackground()
            ->withoutOverlapping();

        // 🧱 Laravel Horizon snapshot stats (if using Horizon)
        $schedule->command('horizon:snapshot')
            ->everyFiveMinutes()
            ->runInBackground();

        // 💾 Backup application daily at 2 AM
        $schedule->command('backup:run')
            ->dailyAt('02:00')
            ->runInBackground();

        // 🧼 Clear old backups weekly (optional)
        $schedule->command('backup:clean')
            ->weeklyOn(1, '03:00')
            ->runInBackground();

        // 🔁 Optional: Run queue worker (use supervisor in prod)
        // $schedule->command('queue:work --stop-when-empty')
        //     ->everyMinute()
        //     ->runInBackground();
    }
}
