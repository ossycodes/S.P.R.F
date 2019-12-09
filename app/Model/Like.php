<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Like extends Model
{
    //allow mass assignment on all attributes
    protected $fillable = ['reply_id', 'user_id'];

    //a like belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //a like belongs to a question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
