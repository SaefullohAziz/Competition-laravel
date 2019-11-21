<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\Uuids;
use App\Contest;


class Competition extends Model
{
	use Softdeletes, UUIDS;

    protected $fillable = [
        'name', 'alias', 'description', 'date', 'theme', 'terms_and_conditions', 'image', 'contact'
    ];
    
    public function contests(){
    	return $this->hasMany(Contest::class);
    }

    /**
     * Main query for listing
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function get(Request $request)
    {
        return DB::table('competitions');
    }

    /**
     * Show the list for datatable
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function list(Request $request)
    {
        return self::get($request)->select('competitions.*');
    }
}
