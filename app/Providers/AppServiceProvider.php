<?php

namespace App\Providers;

use App\Models\Appointment;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::enablePasswordGrant();
        Appointment::observe(\App\Observers\AppointmentObserver::class);
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

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
