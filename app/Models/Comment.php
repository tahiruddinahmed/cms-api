<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    

    /**
     * Comment belongs to user 
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Comment beongs to post
     */
    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }
}
