<?php

namespace App\Jobs;

use App\Models\MonthlyPayment;
use App\Models\Unpaid_member;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateUnpaidMembersJob implements ShouldQueue
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
        logger('unpaid');
        $unpaidMembersIds = Unpaid_member::where('pay_status', false)->where('deleted_at', null)->pluck('user_id');
        // dd($unpaidMembersIds);
        DB::transaction(function() use($unpaidMembersIds){

            $paymentInstance = MonthlyPayment::whereIn('user_id', $unpaidMembersIds)
            ->where('payment_status', true)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get();

            // dd(($paymentInstance));

        if ($paymentInstance->isNotEmpty()) {
            // dd($paymentInstance->pluck('user_id'));
            Unpaid_member::whereIn('user_id', $paymentInstance->pluck('user_id'))->update(['pay_status' => true]);
                dump('<===================updating=====>'.$paymentInstance->pluck('user_id'));
        }

        // dd('end of if block..');
        
        });
        
    }
}
