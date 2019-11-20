<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contest;
use App\Judge;

class ContestJudge extends Model
{
    public function contest(){
    	return $this->belongsTo(Contest::class);
    }

    public function judge(){
    	return $this->hasOne(Judge::class);
    }
}
