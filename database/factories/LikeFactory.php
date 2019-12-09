<?php

use App\User;
use App\Model\Question;
use Faker\Generator as Faker;
use App\Model\Reply;

$factory->define(App\Model\Like::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::all()->random();
        }
        // ,
        // 'reply_id' =>function() {
        //     return Reply::all()->random();
        // }
    ];
});
