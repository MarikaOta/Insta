<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    #Post belongs to a user
    #Use this method to get the owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    #to get the categories under the post
    public function categoryPost(){
        return $this->hasMany(categoryPost::class);
    }

    #Use this method to get all the COMMENTS under a post
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    #Use this method to get the likes of a post
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    #Check if the post been liked
    #Return TRUE if the Auth user already liked the post
    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

}
