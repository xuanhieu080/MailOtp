<?php

namespace XuanHieu\MailOtp;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Xuanhieu080\MailOtp\Services\MailOtpService;

class MailOtpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/config/mail-otp.php' => config_path('mail-otp.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/mail-otp'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'otp');
        View::addNamespace('MailOtp', resource_path('views/vendor/mail-otp'));
    }

    public function register()
    {
        $this->app->singleton('MailOtp', function () {
            return new MailOtpService();
        });
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/mail-otp.php', 'mail-otp');
    }
}
