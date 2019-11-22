<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Uuids;
use App\Contest;

class ContestValuation extends Model
{
	use Uuids;

    public function contest(){
    	return $this->belongsTo(Contest::class);
    }
}
