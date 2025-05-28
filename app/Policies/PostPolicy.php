<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view_post');
    }

    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create_post');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermission('edit_post');
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete_post');
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
