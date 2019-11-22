<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Uuids;
use App\Contest;
use App\Judge;

class ContestJudge extends Model
{
	use Uuids;
	
	protected $fillable = [
        'name', 'username', 'email', 'emeail_verified_at'
    ];

    public function contest(){
    	return $this->belongsTo(Contest::class);
    }

    public function judge(){
    	return $this->hasOne(Judge::class);
    }
}
