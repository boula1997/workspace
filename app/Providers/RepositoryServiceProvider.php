<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

use App\Contracts\Repositories\DeadlineRepositoryInterface;
use App\Repositories\DeadlineRepository;

use App\Contracts\Repositories\DashboardRepositoryInterface;
use App\Repositories\DashboardRepository;

use App\Contracts\Repositories\MarketingRepositoryInterface;
use App\Repositories\MarketingRepository;

use App\Contracts\Repositories\GigRepositoryInterface;
use App\Repositories\GigRepository;

use App\Contracts\Repositories\IssueRepositoryInterface;
use App\Repositories\IssueRepository;

use App\Contracts\Repositories\MiscRepositoryInterface;
use App\Repositories\MiscRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(DeadlineRepositoryInterface::class, DeadlineRepository::class);
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
        $this->app->bind(MarketingRepositoryInterface::class, MarketingRepository::class);
        $this->app->bind(GigRepositoryInterface::class, GigRepository::class);
        $this->app->bind(IssueRepositoryInterface::class, IssueRepository::class);
        $this->app->bind(MiscRepositoryInterface::class, MiscRepository::class);
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
