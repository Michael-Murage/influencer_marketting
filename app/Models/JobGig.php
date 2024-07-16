<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobGig extends Model
{
  use HasFactory;

	public function user() {
		return $this->belongsTo(User::class);
	}

  protected $fillable = [
		'name',
		'description',
		'tags',
		'user_id',
		'applicants',
		'worker_id',
	];
}
