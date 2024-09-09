<?php

namespace App\Models\Workflow;

use App\Models\Workflow\Relationships\WfTrackRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WfTrack extends Model
{
    use HasFactory, WfTrackRelationship, SoftDeletes;
    protected $table = 'main.wf_tracks';
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
