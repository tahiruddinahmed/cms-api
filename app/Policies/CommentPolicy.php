<?php

namespace App\Policies;

use App\Models\User;
use App\Models\comment;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }
}
