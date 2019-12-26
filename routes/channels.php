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

// Broadcast::channel('App.User.0001', function ($user) {
//     return true;
// });

Broadcast::channel('likeReplyChannel', function () {
    return true;
});

Broadcast::channel('deleteReplyChannel', function () {
    return true;
});

Broadcast::channel('createReplyChannel', function () {
    return true;
});
