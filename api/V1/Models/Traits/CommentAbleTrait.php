<?php

namespace Api\V1\Models\Traits;

use Api\V1\Models\Comment;

trait CommentAbleTrait
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
