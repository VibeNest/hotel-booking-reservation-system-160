<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use App\Observers\Booking\Observers\AdminNotifierObserver;
use App\Observers\Booking\Observers\EmailNotifierObserver;
use App\Observers\Booking\Observers\RoomAvailabilityUpdaterObserver;
use App\Services\BookingEventManager;
use Config;
use Illuminate\Support\ServiceProvider;

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
        $this->configureMailSettings();

        $this->registerBookingObservers();
    }

    /**
     * Configure mail settings from database
     */
    private function configureMailSettings(): void
    {
        if (\Schema::hasTable('smtp_settings')) {
            $smtpSetting = SmtpSetting::first();

            if ($smtpSetting) {
                $data = [
                    'driver' => $smtpSetting->mailer,
                    'host' => $smtpSetting->host,
                    'port' => $smtpSetting->port,
                    'username' => $smtpSetting->username,
                    'password' => $smtpSetting->password,
                    'from' => [
                        'address' => $smtpSetting->from_address,
                        'name' => 'HotelHub',
                    ],
                ];
                Config::set('mail', $data);
            }
        }
    }

    /**
     * Register observer pattern for Booking system
     */
    private function registerBookingObservers(): void
    {
        $manager = BookingEventManager::getInstance();

        // Observer order matters: first update availability, then send notifications
        $manager->attach(new RoomAvailabilityUpdaterObserver);
        $manager->attach(new EmailNotifierObserver);
        $manager->attach(new AdminNotifierObserver);
    }
}
