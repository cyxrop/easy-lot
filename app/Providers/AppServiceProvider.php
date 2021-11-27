<?php

namespace App\Providers;

use App\Models\Lot;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        Relation::enforceMorphMap([
            'post' => Lot::class,
            'product' => Product::class,
            'tag' => Tag::class,
            'user' => User::class,
        ]);
    }
}
