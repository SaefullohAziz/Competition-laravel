<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestParticipant extends Model
{
    use Uuids;
	
	protected $fillable = [
        'name', 'username', 'email', 'emeail_verified_at'
    ];
}
