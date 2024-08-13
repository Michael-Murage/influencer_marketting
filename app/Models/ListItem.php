<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListItem extends Model
{
    use HasFactory;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function shortList(): BelongsTo {
        return $this->belongsTo(ShortList::class);
    }

    protected $fillable = [
        'short_list_id',
        'user_id',
    ];
}
