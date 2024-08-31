<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'username',
        'email',
        'phone',
        'password',
        'active',
        'available',
        'entitled_amount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeActiveMembers($query){

        return $query->where('available', true)->where('active', true)
                    ->leftJoin('regions as rgn','rgn.id','=', 'users.region_id')
                    ->leftJoin('districts as dst', 'dst.id', '=', 'users.district_id')
                    ->select('users.*', 'rgn.name as region_name', 'dst.name as district_name');        
                    
    }
}
