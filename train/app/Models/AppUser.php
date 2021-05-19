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

    protected $appends = ['attribute'];

    public function mechanism(){
        return $this->hasOne('App\Models\Mechanism','id','mechanism_id');
    }

    public function tempMechanism(){
        return $this->hasOne('App\Models\Mechanism','id','temp_mechanism_id');
    }

    /** 1-个人 3-机构
     * @return int
     */
    public function getAttributeAttribute(){
        if($this->attributes['mechanism_id']<=1){
            return 1;
        }
        return 3;
    }
}
