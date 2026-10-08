<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function view(User $user, Book $book): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function update(User $user, Book $book): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }
}