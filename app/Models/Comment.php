<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;



class Comment extends Model
{

    protected $fillable=['content','user_id'];

    use SoftDeletes;
    
    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function scopeDernier(Builder $query)
    {
         return $query->orderBy(static::UPDATED_AT,'desc');   
    }

    public static function boot(){
        parent::boot();

        static::addGlobalScope(new LatestScope); 
    }
}
