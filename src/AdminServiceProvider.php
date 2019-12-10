<?php

namespace DarthShelL\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Output\ConsoleOutput;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('DarthShelL\Admin\AdminController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootConfig();
    }

    private function bootConfig() {
        $this->loadViewsFrom(__DIR__.'/views', 'admin');

        $this->publishes([
            __DIR__.'/migrations' => base_path('database/migrations'),
            __DIR__.'/views' => base_path('resources/views/admin'),
            __DIR__.'/css' => base_path('public/css/admin'),
            __DIR__.'/js' => base_path('public/js/admin'),
        ]);

        $this->makeRoutes();
    }

    private function makeRoutes()
    {

//        $console = new ConsoleOutput();

        if (Schema::hasTable('admin_items')) {
            $admin_items = AdminItem::all();

            #TODO: check if route exists

            foreach ($admin_items as $item) {
                Route::{$item->method}($item->route, "{$item->controller}@{$item->action}");
            }
        }else {
//            $console->writeln('<fg=white;bg=red>                                                                                              </>');
//            $console->writeln('<fg=white;bg=red>   DS Admin: table "admin_items" not found. Please publish package and apply migrations:      </>');
//            $console->writeln('<fg=white;bg=red>        php artisan vendor:publish --tag=DarthShelL\Admin\AdminServiceProvider                </>');
//            $console->writeln('<fg=white;bg=red>        php artisan migrate                                                                   </>');
//            $console->writeln('<fg=white;bg=red>                                                                                              </>');
        }
    }
}
