<?php

namespace App\Providers;

use App\Models\Lot;
use App\Models\Product;
use App\Models\Tag;
use App\Policies\LotPolicy;
use App\Policies\ProductPolicy;
use App\Policies\TagPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Product::class => ProductPolicy::class,
         Tag::class => TagPolicy::class,
         Lot::class => LotPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
