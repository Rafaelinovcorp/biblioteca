<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(Login::class, function ($event) {
            $event->user->update(['status' => 'online']);
        });

        Event::listen(Logout::class, function ($event) {
            $event->user->update(['status' => 'offline']);
        });
    }
}
