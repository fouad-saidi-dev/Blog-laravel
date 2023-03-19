<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function posts(){

        return $this->hasMany('App\Models\Post');
    }

    public function comments(){

        return $this->hasMany('App\Models\Comment');
    }



    public function scopeMostUsersActive(Builder $query){
        return $query->withCount('posts')->orderBy('posts_count','desc');
    }

    public function scopeUsersActiveInLastMonth(Builder $query){
        return $query->withCount(['posts' => function(Builder $query){
            $query->whereBetween(static::CREATED_AT,[now()->subDay(1), now()]); //subMonths 
        }])
        ->having('posts_count','>',2)
        ->orderBy('posts_count', 'desc');
    }
}
