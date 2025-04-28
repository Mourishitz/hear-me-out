<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;

class RatingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Rating $rating): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }

    public function delete(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }

    public function restore(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }

    public function forceDelete(User $user, Rating $rating): bool
    {
        return $user->id === $rating->user_id;
    }
}
