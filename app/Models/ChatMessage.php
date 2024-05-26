<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
  use HasFactory;

	public function chatConversation(): BelongsTo
	{
		return $this->belongsTo(ChatConversation::class);
	}

	protected $fillable = [
		'content',
		'chat_conversation_id',
		'sender_id',
		'user_id',
		'message_status',
	];
}
