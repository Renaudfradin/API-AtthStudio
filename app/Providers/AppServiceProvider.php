<?php

namespace App\Providers;

use App\Models\Archive;
use App\Models\Article;
use App\Models\Project;
use Filament\Tables\Table;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
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
        $this->configurePublicRouteBindings();

        Table::configureUsing(function (Table $table): void {
            $table->columnManager();
        });

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    protected function configurePublicRouteBindings(): void
    {
        Route::bind('article', fn (string $value) => Article::query()->active()->where('slug', $value)->firstOrFail());
        Route::bind('project', fn (string $value) => Project::query()->active()->where('slug', $value)->firstOrFail());
        Route::bind('archive', fn (string $value) => Archive::query()->active()->where('slug', $value)->firstOrFail());
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
