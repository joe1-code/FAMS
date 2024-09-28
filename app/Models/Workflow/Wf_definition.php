<?php

namespace App\Models\Workflow;

use App\Models\WfModule;
use App\Models\Workflow\Relationships\WfTrackRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wf_definition extends Model
{
    use HasFactory, WfTrackRelationship;

    public function WfModule(){

        return $this->belongsTo(WfModule::class, 'wf_module_id');
    }
}
