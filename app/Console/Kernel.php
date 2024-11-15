<?php

namespace App\Console;

use App\Jobs\CreateUnpaidMemberJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define Application's commands schedule
     */

    
    protected function schedule(Schedule $schedule)
    {
       //here you can define your jobs
        \Log::info('job is reached'.now());
      //  $schedule->job(new \App\Jobs\CreateUnpaidMemberJob())->monthlyOn(); //this job runs at every 1st of each month to populate the members ready for payment
       $schedule->job(new \App\Jobs\CreateUnpaidMemberJob())->everyMinute(); //this job runs at every 1st of each month to populate the members ready for payment
       $schedule->job(new \App\Jobs\UpdateUnpaidMembersJob())->everyFiveMinutes(); //this job after every 5 mins to update the users who have paid monthly fees
        logger('checks....');
       /**
        * either way to dispatch a job or call exciplictily a dispatch method to sending a job into a queue 
        */
       // $schedule->call(function(){
       //     CreateUnpaidMemberJob::dispatch();
       // })->monthlyOn(1, "00:00");
       
    }
      /**
     * Register the commands for the application.
     */
    // protected function commands(): void
    // {
    //     $this->load(__DIR__.'/Commands');

    //     require base_path('routes/console.php');
    // }
}





?>