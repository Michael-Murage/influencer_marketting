<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, Notifiable;

  public function jobGigs() {
    return $this->hasMany(JobGig::class);
  }

  public function files() {
    return $this->hasMany(File::class);
  }

  public function profilePic() {
    return $this->files()->where('name', 'LIKE', "%profilePic%");
  }

  public function listItems(): HasMany {
    return $this->hasMany(ListItem::class);
  }

  public function shortLists(): HasMany {
    return $this->hasMany(ShortList::class);
  }

  public function applications(): HasMany {
    return $this->hasMany(JobGigApplication::class);
  }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'gender',
        'phone_number',
        'email_verified_at',
        'user_type',
        'company_name',
        'role',
        'company_size',
        'industry',
        'website_url',
        'profession',
        'interest',
        'active_socials',
        'profile_pic',
        'pic_1',
        'pic_2',
        'pic_3',
        'profile_complete',
        'info_gathering_prompted',
        'google_id',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
