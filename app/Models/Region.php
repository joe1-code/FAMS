<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id'];

    public function district(){

        return $this->hasMany(Region::class);
    }

    public function region(){
        return $this->belongsTo(Country::class);
    }
}
