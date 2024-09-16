<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow_track extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'resource_id',
        'wf_definition_id',
        'comments',
        'assigned',
        'parent_id',
        'receive_date',
        'forward_date', 
        'payment_type',
        'resource_type',
        'allocated',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
