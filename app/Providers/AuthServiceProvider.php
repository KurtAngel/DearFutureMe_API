<?php

namespace App\Providers;

use App\Models\Capsule;
use App\Models\ReceivedCapsule;
use App\Policies\CapsulePolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
    protected $policies = [
        Capsule::class => CapsulePolicy::class,
        ReceivedCapsule::class => CapsulePolicy::class, // Adjust according to your logic
    ];
    
}
