<?php

namespace Stellar\Cms\Policies;

class PostPolicy
{
    public function create($user): bool
    {
        if (method_exists($user, 'can_post')) {
            return (bool) $user->can_post();
        }

        return true;
    }

    public function update($user, $post): bool
    {
        $isOwner = isset($post->user_id) && isset($user->id) && (int) $user->id === (int) $post->user_id;
        $isAdmin = method_exists($user, 'is_admin') ? (bool) $user->is_admin() : false;

        return $isOwner || $isAdmin;
    }

    public function delete($user, $post): bool
    {
        return $this->update($user, $post);
    }
}
