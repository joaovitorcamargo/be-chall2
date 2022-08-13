<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use App\Connection\MakeUpClient;
use App\Helpers\OriginCurrencyMoney;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MakeUpClient::class, function () {
            return new MakeUpClient([
                'verify'   => false,
                'base_uri' => env('MAKE_UP_API_URL', ''),
            ]);
        });

        $this->app->bind(OriginCurrencyMoney::class ,function () {
            return new OriginCurrencyMoney([
                'verify'   => false,
                'base_uri' => env('FAST_FOREX_URL', ''),
            ]);
        });
    }
}
