<?php

namespace App\Models;

use App\Enums\ListTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortList extends Model
{
    use HasFactory;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function isPlatformList() {
        return $this->list_type == ListTypeEnum::PLATFORM_LIST;
    }

    public function listItems(): HasMany {
        return $this->hasMany(ListItem::class);
    }

    protected $fillable = [
        'title',
        'user_id',
        'list_type'
    ];
}
