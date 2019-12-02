<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use App\Competition;
use App\ContestJudge;
use App\ContestParticipant;
use App\ContestValuation;
use App\Judge;
use App\Users;

class Contest extends Model
{
	use Uuids, Softdeletes;

    protected $fillable = [
        'name', 'competition_id', 'terms_and_conditions', 'technical_intructions', 'implementation_instructions', 'limit'
    ];
    
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

    /**
     * Main query for listing
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function get(Request $request)
    {
        return DB::table('contests')
                ->join('competitions', 'contests.competition_id', 'competitions.id')
                ->when(! empty($request->competition_id), function($query) use ($request){
                    return $query->where('competitions.id', $request->competition_id);
                }) 
                ->when(! empty($request->contest_name), function($query) use ($request){
                    return $query->where('contests.name', $request->contest_name);
                })
                ->when($request->bin, function($query) use ($request){
                    return $query->whereNotNull('deleted_at');
                })
                ->when(! $request->bin, function($query) use ($request){
                    return $query->whereNull('deleted_at');
                });
    }

    /**
     * Show the list for datatable
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function list(Request $request)
    {
        return self::get($request)->select('contests.*', 'competitions.name AS competitions');
    }
}
