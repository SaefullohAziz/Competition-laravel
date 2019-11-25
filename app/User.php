<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contest;
use App\School;
use App\ContestParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Uuids, Notifiable, Softdeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's avatar.
     *
     * @param  string  $value
     * @return string
     */
    public function getAvatarAttribute()
    {
        if ($this->photo == 'avatar.png') {
            return '/img/avatar/avatar.png';
        }
        return '/storage/avatar/' . $this->photo;
    }

    public function contestParticipant()
    {
        return $this->belongsToMany(ContestParticipant::class);
    }

    public function contests()
    {
        return $this->HasMany(Contest::class)->using(ContestParticipant::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public static function get(Request $request)
    {
        return DB::table('users');
    }

    /**
     * Show the list for datatable
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public static function list(Request $request)
    {
        return self::get($request)->select('users.*');
    }
}
