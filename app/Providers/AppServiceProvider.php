<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use App\Observers\Booking\Observers\AdminNotifierObserver;
use App\Observers\Booking\Observers\EmailNotifierObserver;
use App\Observers\Booking\Observers\RoomAvailabilityUpdaterObserver;
use App\Services\BookingEventManager;
use Config;
use Illuminate\Support\Facades\Mail;
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
        try {
            if (\Schema::hasTable('smtp_settings')) {
                $smtpSetting = SmtpSetting::first();

                if ($smtpSetting) {
                    Config::set('mail.driver', null);
                    Config::set('mail.default', $smtpSetting->mailer ?: 'smtp');
                    Config::set('mail.mailers.smtp.transport', 'smtp');
                    Config::set('mail.mailers.smtp.scheme', $smtpSetting->mailerScheme());
                    Config::set('mail.mailers.smtp.encryption', $smtpSetting->mailerEncryption());
                    Config::set('mail.mailers.smtp.url', null);
                    Config::set('mail.mailers.smtp.host', $smtpSetting->host);
                    Config::set('mail.mailers.smtp.port', $smtpSetting->port);
                    Config::set('mail.mailers.smtp.username', $smtpSetting->username);
                    Config::set('mail.mailers.smtp.password', $smtpSetting->sanitizedPassword());
                    Config::set('mail.from.address', $smtpSetting->from_address);
                    Config::set('mail.from.name', 'HotelHub');

                    Mail::forgetMailers();
                }
            }
        } catch (\Throwable $e) {
            // Database not yet available (e.g., during composer install, CI without .env).
            // Mail settings will be configured later when the app is fully booted.
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
