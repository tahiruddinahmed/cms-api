<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    
    /**
     * admin belongs to user
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
