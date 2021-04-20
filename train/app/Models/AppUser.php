<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;

class AppUser extends User
{

    protected $table = 'app_user';
    protected $fillable=[
        'user_id',
        'name',
        'nick_name',
        'phone',
        'sex',
        'birthday',
        'password',
        'attribute',
        'avatar',
        'mechanism_id',
        'industry_id',
        'occupation_id',
        'api_token',
        'status'
    ];
    protected $hidden=[
        'password'
    ];

    public function mechanism(){
        return $this->hasOne('App\Models\Mechanism','id','mechanism_id');
    }

    public function industry(){
        return $this->hasOne('App\Models\Industry','id','industry_id');
    }

    public function occupation_id(){
        return $this->hasOne('App\Models\Occupation','id','occupation_id');
    }
}
