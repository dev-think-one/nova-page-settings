<?php

namespace Thinkone\NovaPageSettings;

use Illuminate\Support\Facades\Gate;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/nova-page-settings.php' => config_path('nova-page-settings.php'),
            ], 'config');


            $this->commands([
            ]);
        }

        Gate::policy(
            \Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel::class,
            config('nova-page-settings.adapter_model_policy')
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-page-settings.php', 'nova-page-settings');
    }
}
