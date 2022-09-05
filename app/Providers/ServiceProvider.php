<?php

declare(strict_types=1);

namespace App\Providers;

use InvalidArgumentException;

class ServiceProvider
{
    private array $services = [];

    private array $instantiated = [];

    private static $instance = null;

    private function __construct()
    {
    }

    public function addInstance(string $class, $service)
    {
        $this->instantiated[$class] = $service;
    }

    public function addClass(string $class, array $params)
    {
        $this->services[$class] = $params;
    }

    public function has(string $interface): bool
    {
        return isset($this->services[$interface]) || isset($this->instantiated[$interface]);
    }

    public function get(string $class)
    {
        if (isset($this->instantiated[$class])) {
            return $this->instantiated[$class];
        }

        $object = new $class(...$this->services[$class]);

        if (!$object instanceof Service && !$object instanceof Repository) {
            throw new InvalidArgumentException('Could not register service or repository: is no instance of Service or repository');
        }

        $this->instantiated[$class] = $object;

        return $object;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new ServiceProvider;
        }
        return self::$instance;
    }
}