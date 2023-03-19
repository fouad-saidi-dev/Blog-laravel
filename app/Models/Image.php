<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;


class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function url(){
        return Storage::url($this->path);
    }
}
