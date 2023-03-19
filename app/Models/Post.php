<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LatestScope;
use App\Scopes\AdminShowDeleteScope;

use Illuminate\Database\Eloquent\Builder;



class Post extends Model
{
    
    //simplifier pour delete posts with comments from DB 
    use softDeletes;

    use HasFactory;

    //les champs de remplissage lorsque tu veux creer un post
    protected $fillable=['title','content','slug','active','user_id'];

    //post have a lot of comments
    public function comments(){
        return $this->hasMany('App\Models\Comment')->dernier();
    }

    // posts for one user 
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function image(){
        return $this->hasOne('App\Models\Image');
    }

    public function scopeMostCommented(Builder $query){
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }


    // if u want delete a post form db but comments still on db use that 
    public static function boot(){
       
        //must be before boot() for working because softdelete used before scope  
        static::addGlobalScope(new AdminShowDeleteScope);
       
        parent::boot();

        

        static::addGlobalScope(new LatestScope);

        static::deleting(function(Post $post){
            //dd('deleting'); 
            $post->comments()->delete();
        });

        static::restoring(function(Post $post){
            //dd('deleting'); 
            $post->comments()->restore();
        });
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }
}
