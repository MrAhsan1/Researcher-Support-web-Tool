<?php

namespace App\Console;

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
       
        $schedule->call('App\Http\Controllers\EricController@machine')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@dbms')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@artificial')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@recommendation')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@rfid')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@iot')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@image')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@cv')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@datamining')->everyMinute();
        $schedule->call('App\Http\Controllers\EricController@nlp')->everyMinute();

        $schedule->call('App\Http\Controllers\IngentaController@machine')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@dbms')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@artificial')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@recommendation')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@rfid')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@iot')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@image')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@cv')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@datamining')->everyMinute();
        $schedule->call('App\Http\Controllers\IngentaController@nlp')->everyMinute();
     
        $schedule->call('App\Http\Controllers\PubController@machine')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@dbms')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@artificial')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@recommendation')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@rfid')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@iot')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@image')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@cv')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@datamining')->everyMinute();
        $schedule->call('App\Http\Controllers\PubController@nlp')->everyMinute();

        $schedule->call('App\Http\Controllers\ScraperController@machine')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@dbms')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@artificial')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@rfid')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@iot')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@image')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@cv')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@datamining')->everyMinute();
        $schedule->call('App\Http\Controllers\ScraperController@nlp')->everyMinute();

        $schedule->call('App\Http\Controllers\ACMScrapeController@machine')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@artificial')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@recommendation')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@dbms')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@nlp')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@cv')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@rfid')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@image')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@iot')->everyMinute();
        $schedule->call('App\Http\Controllers\ACMScrapeController@datamining')->everyMinute();

        $schedule->call('App\Http\Controllers\NotificationController@query')->everyMinute();
        
        $schedule->call('App\Http\Controllers\ScraperController@recommendation')->everyMinute();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
