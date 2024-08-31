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

    public function notPaidMembers($query){

        return $query->where('available', true)->where('active', true)
                        ->leftJoin('users as usr', 'usr.id', '=', 'MonthlyPayments.user_id')
                        ->leftJoin('regions as rgn','rgn.id','=', 'users.region_id')
                        ->leftJoin('districts as dst', 'dst.id', '=', 'users.district_id')
                        ->select('users.*', 'rgn.name as region_name', 'dst.name as district_name')
                        ->where;        
        
    }
}
