<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Question;
use App\Model\Reply;
use App\Model\Like;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


     /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    // public function receivesBroadcastNotificationsOn()
    // {
    //     return 'App.User.0001';
    // }

    /**
     * Encrypts the User's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    //user can ask many questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    //user can have many replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //user can have many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
