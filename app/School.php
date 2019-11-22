<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\User;

class School extends Model
{
	use Uuids, Softdeletes;

	protected $fillable = [
        'name', 'type', 'email', 'address'
    ];

    public function users(){
    	return $this->hasMany(User::class);
    }

    /**
     * Main query for listing
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function get(Request $request)
    {
        return DB::table('schools')
                ->whereNull('schools.deleted_at');
    }

    /**
     * Show the list for datatable
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function list(Request $request)
    {
        return self::get($request)->select('schools.*');
    }
}
