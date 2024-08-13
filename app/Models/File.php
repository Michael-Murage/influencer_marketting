<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  use HasFactory;

	public function user() {
		return $this->belongsTo(User::class);
	}

	protected $fillable = [
		'name', 'user_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function name(): Attribute
	{
		return Attribute::make(
			get: fn ($value) => url('storage/'.$value),
		);
	}
}
