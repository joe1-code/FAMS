<?php
namespace App\Models\Workflow\Relationships;

use App\Models\Workflow\Wf_definition;

trait WfTrackRelationship
{
    public function WfDefinition(){

        return $this->belongsTo(Wf_definition::class);
    }

}











?>