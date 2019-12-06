<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('entryNo', function ($expression) {
            $parameters = explode(', ', $expression);
            list($key, $currentPage, $perPage) = $parameters;

            return "<?php echo ($key + ($currentPage - 1) * $perPage + 1); ?>";
        });

        Blade::directive('media', function ($expression) {
            $parameters = explode(', ', $expression);
            $media = $parameters[0];
            $size = $parameters[1] ?? 'original';

            return "<?php echo ($media)->getImageUrl($size); ?>";
        });
    }
}
