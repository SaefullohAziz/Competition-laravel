<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Competition;
use App\ContestJudge;
use App\ContestParticipant;
use App\ContestValuation;
use App\Judge;
use App\Users;

class Contest extends Model
{
	use Softdeletes;
    
    public function competition(){
    	return $this->hasOne(Competition::class);
    }

    public function contestValuation(){
    	return $this->hasMany(ContestValuation::class);
    }

    public function contestJudge(){
    	return $this->hasMany(ContestJudge::class);
    }

    public function judges(){
    	return $this->hasMany(Judge::class)->using(ContestJudge::class);
    }

    public function contestParticipant(){
    	return $this->hasMany(ContestParticipant::class);
    }

    public function participants(){
    	return $this->hasMany(User::class)->using(ContestParticipant::class);
    }

}
