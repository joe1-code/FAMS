<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\PaymentsRepository;
use App\Repositories\PaymentsRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\WfDefinitionRepository;
use App\Repositories\WfDefinitionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PaymentsRepositoryInterface::class, PaymentsRepository::class);
        $this->app->bind(BaseRepository::class, DocumentRepository::class);
        $this->app->bind(WfDefinitionRepositoryInterface::class, WfDefinitionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('Helpers/helpers.php');
        
    }
}
