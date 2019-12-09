<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'body', 'user_id', 'category_id'];

    /**
     * always called after registering the service.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        //listen to the question creating event
        //executes when the question model is created for the first time
        static::creating(function ($question) {
            $question->slug = str_slug($question->title);
        });
    }

    protected $with = ['replies'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPathAttribute()
    {
        return "/questions/$this->slug";
    }

    //a question can be asked by a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //a question can have many replies
    public function replies()
    {
        return $this->hasMany(Reply::class)->latest();
    }

    //a question belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //a question can have many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
