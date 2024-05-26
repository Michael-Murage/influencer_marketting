<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public object $message;
  public $conversation_id;

  /**
   * Create a new event instance.
   */
  public function __construct(object $message, $conversation_id)
  {
    $this->message = $message;
    $this->conversation_id = $conversation_id;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */
  public function broadcastOn(): array
  {
    return [
      new Channel("private.chatmessage.$this->conversation_id"),
    ];
  }

	public function broadcastAs()
	{
		return 'chat';
	}

  public function broadcastWith()
  {
    return [
      'message' => $this->message,
    ];
  }
}
