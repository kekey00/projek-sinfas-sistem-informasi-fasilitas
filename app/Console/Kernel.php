<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Kernel Perintah Konsol SINFAS.
 *
 * Mengelola penjadwalan tugas otomatis (cron job) dan pendaftaran perintah artisan khusus aplikasi.
 *
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * Tentukan jadwal tugas berkala (cron job) untuk aplikasi.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Daftarkan perintah artisan khusus untuk aplikasi SINFAS.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
