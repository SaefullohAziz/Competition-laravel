<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Judge;
use App\ContestValuation;

class UserContestScore extends Model
{
	public function contestValuation(){
    	return $this->belongsTo(ContestValuation::class);
    }

    public function contest(){
    	return $this->belongsTo(Contest::class)->using(ContestValuation::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function judge(){
    	return $this->belongsTo(Judge::class);
    }
}
