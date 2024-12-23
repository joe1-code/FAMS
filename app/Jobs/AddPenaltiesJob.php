<?php

namespace App\Jobs;

use App\Models\MonthlyPayment;
use App\Models\Unpaid_member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddPenaltiesJob implements ShouldQueue
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
       /**
        * 1. prepare job to check if the arrears have been paid otherwise add penalties to user
        */

        //calculate the percentage of penalty
        $penalty = 0;
        //past month arrears
        $arrears_instance = Unpaid_member::join('users as u', 'u.id', '=', 'unpaid_members.user_id')
                            ->where('pay_status', false)->whereNotNull('unpaid_members.deleted_at')
                            ->whereBetween('unpaid_members.created_at',[Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                            ->get();

        
        // dd($arrears_instance);
        foreach ($arrears_instance as $arrears) {
                
        if ($arrears->penalty == null and $arrears->total_arrears == null) {
                dump('<=================== arrears==============>'. 1);

                if (!empty($arrears->paid_amount)) {
                    
                    $diff_amount = $arrears->entitled_amount - $arrears->paid_amount;

                    $penalty = (50/100) * ($diff_amount);

                    $total_arrears = $diff_amount + $penalty;
                }
                else {
                    
                    $penalty = (50/100) * ($arrears->entitled_amount);

                    $total_arrears = $arrears->entitled_amount + $penalty;

                }

                Unpaid_member::where('user_id', $arrears->id)->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->update(['penalty' => $penalty, 'total_arrears' => $total_arrears]);
            }
            
        }
    }
}
