<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contest;

class ContestValuation extends Model
{
    public function contest(){
    	return $this->belongsTo(Contest::class);
    }
}
