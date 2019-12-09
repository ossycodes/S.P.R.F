<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    // return true;
    // // return true;
    dd($user->id, $id);
    // // dd($user);
    // return (int) 2 === (int) $id;
    // return $user->id === $user->id;
});

Broadcast::channel('likeReplyChannel', function () {
    return true;
});

Broadcast::channel('deleteReplyChannel', function () {
    return true;
});
