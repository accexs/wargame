<?php

namespace App\Providers;

use App\Repository\ArmyRepositoryInterface;
use App\Repository\Cache\ArmyRepository;
use App\Repository\Cache\BaseRepository;
use App\Repository\CacheRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CacheRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ArmyRepositoryInterface::class, ArmyRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
