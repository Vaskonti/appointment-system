<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\ReminderOffsets;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(PasswordProvider::class);
        $this->app->register(RateLimiterProvider::class);
        $this->app->register(InterfaceImplementationProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::enablePasswordGrant();
        Appointment::observe(\App\Observers\AppointmentObserver::class);
        ReminderOffsets::observe(\App\Observers\ReminderOffsetsObserver::class);
    }
}
