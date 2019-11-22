<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Uuids;
use App\User;
use App\Judge;
use App\ContestValuation;

class UserContestScore extends Model
{
    use Uuids;

    protected $fillable = [
        'contest_valuation_id', 'user_id', 'judge_id', 'scores'
    ];

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
