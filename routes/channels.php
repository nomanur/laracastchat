<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('tasks.{projectId}', function ($user, \App\Project $projectId) {

	return $projectId->participants->contains($user);
    //return (int) $user->id === (int) $id;

    // $canAccess=[];

    // if ($user->email == 'noman@gmail.com') {
    // 	$canAccess=[1,3];
    // }
    // if ($user->email == 'rahman@gmail.com') {
    // 	$canAccess=[2,4];
    // }
    // return in_array($projectId, $canAccess);
});
