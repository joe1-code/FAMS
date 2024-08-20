<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'paid_amount',
        'document_id',
        'doc_used',
        'entitled_amount',
        'pay_date',
        'payment_status',
        'approval_status',
        'total_contributions',
        'created_at',
        'updated_at',
    ];
}
