<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contest;

class Competition extends Model
{
	use Softdeletes;
    
    public function contests(){
    	return $this->hasMany(Contest::class);
    }
}
