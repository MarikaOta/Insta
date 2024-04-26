<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, Softdeletes;

    #Use this methos to get the OWNER of the comment
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
