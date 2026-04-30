<?php

namespace Stellar\Cms;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Stellar\Cms\Policies\PostPolicy;

class StellarCmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/stellar-cms.php', 'stellar-cms');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'stellar-cms');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $postModel = config('stellar-cms.models.post');
        if (is_string($postModel) && class_exists($postModel)) {
            Gate::policy($postModel, PostPolicy::class);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/stellar-cms.php' => config_path('stellar-cms.php'),
            ], 'stellar-cms-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/stellar-cms'),
            ], 'stellar-cms-views');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'stellar-cms-migrations');
        }
    }
}
