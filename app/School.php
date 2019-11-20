<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\User;

class School extends Model
{
	use Uuids, Softdeletes;
    public function users(){
    	return $this->hasMany(User::class);
    }
}
