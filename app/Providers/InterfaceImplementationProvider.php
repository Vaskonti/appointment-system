<?php

namespace App\Providers;

use App\Models\Appointment;
use Illuminate\Support\ServiceProvider;

class InterfaceImplementationProvider extends ServiceProvider
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
        Appointment::observe(\App\Observers\AppointmentObserver::class);

        $this->app->bind(
            \App\Services\User\UserServiceInterface::class,
            \App\Services\User\UserService::class
        );

        $this->app->bind(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );

        $this->app->bind(
            \App\Services\Appointment\AppointmentServiceInterface::class,
            \App\Services\Appointment\AppointmentService::class
        );

        $this->app->bind(
            \App\Repositories\Appointment\AppointmentRepositoryInterface::class,
            \App\Repositories\Appointment\AppointmentRepository::class
        );

        $this->app->bind(
            \App\Repositories\Client\ClientRepositoryInterface::class,
            \App\Repositories\Client\ClientRepository::class
        );
    }
}
