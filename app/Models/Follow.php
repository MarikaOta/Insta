<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;


    ### Note: THE AUTH user ( Auth::user()->id ) --->will always be the follower


    #Use this method to get info of a follower
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }


    #Use this method to get the info of the user being followed
    public function following()
    {
        // return $this->belongsTo(User::class, 'following_id');
        return $this->belongsTo(User::class)->withTrashed();
    }
}
