<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\Interfaces\ArticleInterface;
use App\Services\Interfaces\ArticlesService;
use App\Services\ArticlesServiceImpl;
use App\Repositories\AuthRepository;
use App\Repositories\Interfaces\AuthInterface;
use App\Services\Interfaces\AuthService;
use App\Services\AuthServiceImpl;
use App\Database\Interfaces\DBInterface;
use App\Database\DB;

use Dotenv;

class AppServiceProvider
{
    protected $serviceProvider;

    public function __construct()
    {
        $this->dotEnv();
        $this->serviceProvider = ServiceProvider::getInstance();
        $this->register();
    }

    protected function register()
    {
        $this->serviceProvider->addInstance(DBInterface::class, new DB);

        $this->serviceProvider->addInstance(ArticleInterface::class, new ArticleRepository($this->serviceProvider->get(DBInterface::class)));
        $this->serviceProvider->addInstance(ArticlesService::class, new ArticlesServiceImpl);

        $this->serviceProvider->addInstance(AuthInterface::class, new AuthRepository($this->serviceProvider->get(DBInterface::class)));
        $this->serviceProvider->addInstance(AuthService::class, new AuthServiceImpl);
    }

    public function dotEnv()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
    }
}

new AppServiceProvider;