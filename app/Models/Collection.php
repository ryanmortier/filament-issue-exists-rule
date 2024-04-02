<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Collection extends Model
{
    use HasFactory;

    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class)->withTimestamps();
    }

    public function scopeOwnedByCurrentUser(Builder $query): void
    {
        $query->where('user_id', '=', Auth::user()->id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
