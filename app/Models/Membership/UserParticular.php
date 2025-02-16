<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserParticular extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "main.user_particulars";
    protected $fillable = [
        'user_id',
        'country_id',
        'tin_no',
        'nin',
        'passport_no',
        'address',
        'fax',
        'monthly_earning',
        'location_type',
        'unsurveyed_area_description',
        'road',
        'plot_no',
        'block_no',
        'street',
        'surveyed_area_description',
        'job_description',
        'business_name',
        'business_nature',
        'foundation_education',
        'foundation_start_date',
        'foundation_end_date',
        'secondary_education',
        'secondary_start_date',
        'secondary_end_date',
        'college_education',
        'college_start_date',
        'college_end_date',
        'university_education',
        'university_start_date',
        'university_end_date',
        'education_level',
        'diploma_degree_name',
        'edu_completion_date',
        'family_group_id',
        'created_at',
        'updated_at',
        'deleted_at'                                  
    ];
}
