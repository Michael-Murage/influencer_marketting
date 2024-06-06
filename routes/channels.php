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

Broadcast::channel('private.chatmessage.{id}', function ($user, $conversation_id) {
  // return (int) $user->id === (int) $id;
  $conversation = \App\Models\ChatConversation::find($conversation_id);
  if ($conversation->user_1_id == $user->id || $conversation->user_2_id == $user->id) {
		return true;
	}
	return false;
});
