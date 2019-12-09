<?php

namespace App\Model;

use App\User;
use App\Model\Question;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    //a reply belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //a reply belongs to a question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    //a reply can have many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
