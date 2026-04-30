<?php

namespace Stellar\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $guarded = [];

    public function comments(): HasMany
    {
        $commentModel = config('stellar-cms.models.comment', Comment::class);

        return $this->hasMany($commentModel, 'on_post');
    }

    public function author(): BelongsTo
    {
        $userModel = config('stellar-cms.models.user') ?: config('auth.providers.users.model');

        return $this->belongsTo($userModel, 'user_id');
    }

    public function getTable(): string
    {
        return config('stellar-cms.tables.posts', parent::getTable());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

