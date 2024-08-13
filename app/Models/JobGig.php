<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobGig extends Model
{
  use HasFactory;

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function userInformation() {
		return $this->belongsTo(User::class, 'user_id')->with('profilePic')->select('id', 'name');
	}

	public function applications(): HasMany {
		return $this->hasMany(JobGigApplication::class);
	}

  protected $fillable = [
		'name',
		'description',
		'tags',
		'user_id',
		'worker_id',
		'role',
		'qualifications',
	];
}
