<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paid_amount',
        'entitled_amount',
        'pay_date',
        'payment_status',
        'approval_status',
        'total_contributions',
        'created_at',
        'updated_at',
    ];
}
