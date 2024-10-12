<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Capsule;
use App\Models\received_capsule;
use App\Models\ReceivedCapsule;
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

    public function modify_receiver(User $user, ReceivedCapsule $capsule): Response {

        return $user->email === $capsule->receiver_email
        ? Response::allow()
        : Response::deny('You do not own this Capsule');
    }
}
