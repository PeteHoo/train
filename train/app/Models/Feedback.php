<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'phone'
    ];

    public function appUser(){
        return $this->hasOne('App\Models\AppUser','user_id','user_id');
    }
}
