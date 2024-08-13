<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobGigApplication extends Model
{
  use HasFactory;

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	public function applicationWithUserDetails() {
		return $this->user()->with('profilePic')->select(['id', 'name', 'username', 'email']);
	}

	public function jobGig(): BelongsTo {
		return $this->belongsTo(JobGig::class);
	}

	protected $fillable = [
		'user_id',
		'job_gig_id',
	];
}
