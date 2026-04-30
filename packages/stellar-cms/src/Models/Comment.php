<?php

namespace Stellar\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $guarded = [];

    public function author(): BelongsTo
    {
        $userModel = config('stellar-cms.models.user') ?: config('auth.providers.users.model');

        return $this->belongsTo($userModel, 'from_user');
    }

    public function post(): BelongsTo
    {
        $postModel = config('stellar-cms.models.post', Post::class);

        return $this->belongsTo($postModel, 'on_post');
    }

    public function getTable(): string
    {
        return config('stellar-cms.tables.comments', parent::getTable());
    }
}

