<?php

use App\Booking;
use App\User;
use Illuminate\Notifications\Channels\BroadcastChannel;

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
    // return (int) $user->id === (int) $id;
    return true;
});

Broadcast::channel('BookingMessageChannel.{id}', function ($user, $id) {
    return ['id' => $user->name, 'name' => $user->name. ' ' .$user->lastname];
    // return true;
});

Broadcast::channel('ApiMessagesChannel.{id}', function(){
    return true;
});
