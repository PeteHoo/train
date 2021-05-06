<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UpdatePlan extends Model
{
	
    protected $table = 'update_plan';

    public function versionName(){
        return $this->hasOne('App\Models\Version','id','name');
    }
    public function afterVersion(){
        return $this->hasOne('App\Models\Version','id','after_version');
    }
    public function beforeVersion(){
        return $this->hasOne('App\Models\Version','id','before_version');
    }
}
