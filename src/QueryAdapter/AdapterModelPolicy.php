<?php


namespace Thinkone\NovaPageSettings\QueryAdapter;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class AdapterModelPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user)
    {
        return true;
    }

    public function update(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }

    public function forceDelete(User $user)
    {
        return false;
    }
}
