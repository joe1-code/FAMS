<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unpaid_member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pay_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
