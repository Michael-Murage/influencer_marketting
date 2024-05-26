<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
  use HasFactory;
	
	public function chatMessages(): HasMany
	{
		return $this->hasMany(ChatMessage::class);
	}

	public function latestMessage() {
		return $this->hasOne(ChatMessage::class)->latest();
	}
	
	protected $fillable = [
		'user_1_name',
		'user_2_name',
		'user_1_id',
		'user_2_id',
	];
}
