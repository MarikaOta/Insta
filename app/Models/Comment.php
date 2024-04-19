<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    #Use this methos to get the OWNER of the comment
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
