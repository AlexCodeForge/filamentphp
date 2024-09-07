<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use BezhanSalleh\PanelSwitch\PanelSwitch;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalWidth('sm')
                ->slideOver()
                ->visible(fn (): bool => auth()->user()?->hasAnyRole([
                    'admin',
                    'general_manager',
                    'super_admin',
                ]))
                ->labels([
                    'admin' => 'Admin Panel',
                    'personal' => 'Personal Panel',
                ])
                ->icons([
                    'admin' => 'heroicon-o-square-2-stack',
                    'personal' => 'heroicon-o-star',
                ])
                ->iconSize(16);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
