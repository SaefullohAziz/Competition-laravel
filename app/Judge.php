<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Uuids;
use App\Contest;
use App\ContestJudge;

class Judge extends Authenticatable
{
	use Softdeletes, Uuids;

	protected $fillable = [
        'name', 'address', 'carrier', 'organitation', 'gender', 'username', 'email', 'email_verified_at', 'password', 'photo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function contestJudge(){
    	return $this->belongsTo(ContestJudge::class);
    }

    public function contests(){
    	return $this->belongsToMany(ContestJudge::class)->using(ContestJudge::class);
    }
}
