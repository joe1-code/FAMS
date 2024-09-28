<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WfModule extends Model
{
    use HasFactory;

    protected $table = "main.wf_modules";

    public function WfModuleGroup(){

        return $this->belongsTo(WfModule::class, 'wf_module_group_id');
    }

}
