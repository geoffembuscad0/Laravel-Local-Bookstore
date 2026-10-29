<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;

class AuthorPolicy {
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function view(User $user, Author $author): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function update(User $user, Author $author): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function delete(User $user, Author $author): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }
}