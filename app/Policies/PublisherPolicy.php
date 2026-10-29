<?php

namespace App\Policies;

use App\Models\Publisher;
use App\Models\User;

class PublisherPolicy {
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function view(User $user, Publisher $publisher): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function update(User $user, Publisher $publisher): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function delete(User $user, Publisher $publisher): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }
}