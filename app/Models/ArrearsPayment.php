<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrearsPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'paid_amount',
        'document_id',
        'doc_used',
        'pay_date',
        'payment_status',
        'payment_method_id',
        'approval_status',
        'total_arrears',
        'created_at',
        'updated_at',
        'deleted_at',
        'unpaid_member_id',
    ];

               
    

}
