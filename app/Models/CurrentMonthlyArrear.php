<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentMonthlyArrear extends Model
{
    use HasFactory;

    protected $table = 'main.current_monthly_arrears';

    protected $fillable = [
        'user_id',
        'outstanding_amount',
        'pay_date',
        'approval_id',
        'monthly_payments_id',
        'previous_monthly_arrears_id',      
    ];
}
