<?php

namespace App\Console;

use App\Events\ClientTransactionHasEnded;
use App\Transaction;
use Carbon\Carbon;
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
        // $schedule->command('inspire')
        //          ->hourly();


        $schedule->call(function() {
            $transactions = Transaction::where('type', 'REGULAR')
                ->where('status', 'CLOCKED IN')
                ->whereBetween('end', [Carbon::now('Asia/Manila')->subMinutes(5), Carbon::now('Asia/Manila')])
                ->get()
                ->map
                ->format();

            if ($transactions->count() > 0) {
                foreach($transactions as $transaction) {
                    event(new ClientTransactionHasEnded($transaction));
                }
            }
        });
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
