<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

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
        $this->configureRateLimiting();

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(config('rate_limiting.api.limit', 60))
                ->by($request->ip())
                ->response($this->tooManyRequestsResponse(...));
        });

        RateLimiter::for('strict', function (Request $request) {
            return Limit::perMinute(config('rate_limiting.strict.limit', 20))
                ->by($request->ip())
                ->response($this->tooManyRequestsResponse(...));
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(config('rate_limiting.login.limit', 5))
                ->by($request->ip())
                ->response($this->tooManyRequestsResponse(...));
        });
    }

    /**
     * @param  array<string, mixed>  $headers
     */
    protected function tooManyRequestsResponse(Request $request, array $headers): Response
    {
        return response()->json([
            'message' => 'Trop de requêtes. Veuillez réessayer plus tard.',
        ], 429, $headers);
    }
}
