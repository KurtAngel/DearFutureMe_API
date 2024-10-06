<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Capsule;
use Illuminate\Auth\Access\Response;

class CapsulePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function modify(User $user, Capsule $capsule): Response {
        return $user->id === $capsule->user_id
            ? Response::allow()
            : Response::deny('You do not own this Capsule');
    }
}
