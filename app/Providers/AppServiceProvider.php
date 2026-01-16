<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Your existing logo
        $logoPath = public_path('images/ztl-logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
        View::share('logoBase64', $logoBase64);

        // ADD THIS: waves image as base64
        $wavesPath = public_path('storage/waves.png');  // your file location
        $wavesBase64 = '';
        if (file_exists($wavesPath)) {
            $wavesBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($wavesPath));
        }
        View::share('wavesBase64', $wavesBase64);
    }
}
