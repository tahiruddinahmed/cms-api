<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'catgory_id', 'title', 'post_img', 'content', 'category_id'];


    /**
     * Post belongs to a user 
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Post belongs to category 
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    /**
     * Post has many comments 
     */
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
