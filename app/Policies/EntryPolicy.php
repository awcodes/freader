<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Entry $entry)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Entry $entry)
    {
        return false;
    }

    public function delete(User $user, Entry $entry)
    {
        return true;
    }
}
