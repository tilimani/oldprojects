<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->formatScheme('https');
        }
        Schema::defaultStringLength(191);
        // Debugger of query to data base
        // \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
          //   // dd($query);
            //  echo '<pre>';
              //print_r([ $query->sql, $query->time . ' ms']);
              //echo '</pre>';
        //});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
