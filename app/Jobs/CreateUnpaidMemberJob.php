<?php

namespace App\Jobs;

use App\Models\Unpaid_member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateUnpaidMemberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pastMonthdata = Unpaid_member::whereBetween('created_at', 
                        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                        ->get();
        // dd(($pastMonthdata));
        if ($pastMonthdata->isNotEmpty()) {
            // dd(1);
            foreach ($pastMonthdata as $data) {
                    // dump($data['user_id']);
                    Unpaid_member::where('user_id', $data['user_id'])->update(['deleted_at'=>Carbon::now()]);
            }
        }
        
        // dd($pastMonthdata);

        $members = User::ActiveMembers()->get();
        // $members = User::all();
        foreach ($members as $member) {

            Unpaid_member::where('deleted_at', null)->updateorCreate([
                'user_id' => $member->id,
                'pay_status' => false
            ]);
        }
    }
}
