<?php

namespace App\Policies;

use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Authenticatable $user){

        return $user->type == 'edit' || $user->type == 'admin';
    }
}
