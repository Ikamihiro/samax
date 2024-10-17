<?php

namespace Core\Foundation;

use Core\Foundation\Container;

class Application extends Container
{
    /**
     * The array of registered managers
     * 
     * @var array
     */
    protected array $managers = [];

    /**
     * The array of configuration values
     * 
     * @var array
     */
    protected array $config = [];

    /**
     * The base path of the application
     * 
     * @var string
     */
    protected string $basePath;

    public function __construct(?string $basePath = null)
    {
        parent::__construct();

        $this->basePath = $basePath ?? $_ENV['BASE_PATH'];

        // Start booting the application
        $this->booting();
    }

    /**
     * Get the base path of the application
     * 
     * @return string
     */
    public function basePath(): string
    {
        return $this->basePath;
    }

    /**
     * Start boot of the application
     * 
     * @return void
     */
    protected function booting(): void
    {
        // Register the application instance
        $this->registerItSelf();

        // Load the configuration files
        $this->loadConfigurationFiles();

        // Load the managers
        $this->loadManagers();
    }

    private function registerItSelf(): void
    {
        $this->singleton(Container::class, $this);
    }

    /**
     * Load the configuration files from the config directory
     * 
     * @return void
     */
    private function loadConfigurationFiles(): void
    {
        // Load the configuration files
        $configFiles = glob($this->basePath . 'config/*.php');

        // Loop through the configuration files
        foreach ($configFiles as $configFile) {
            // Load the configuration file
            $config = require $configFile;

            // Store the configuration values in the config array
            $this->config[basename($configFile, '.php')] = $config;
        }
    }

    /**
     * Load the managers from the configuration file
     * 
     * @return void
     */
    private function loadManagers(): void
    {
        $managers = $this->config['app']['managers'] ?? [];

        foreach ($managers as $managerClass) {
            $managerInstance = new $managerClass($this);

            $this->registerManager($managerClass, $managerInstance);
        }

        // Register and boot the managers
        foreach ($this->managers as $manager) {
            /**
             * @var Manager $manager
             */
            $manager->register();
            // dd($manager);
            $manager->boot();
        }
    }

    /**
     * Register a manager
     * 
     * @param string $managerClass
     * @param mixed $managerInstance
     * 
     * @return void
     */
    protected function registerManager(string $managerClass, mixed $managerInstance): void
    {
        if (isset($this->managers[$managerClass])) {
            throw new \Exception("Manager $managerClass is already registered");
        }

        // Store the manager in the managers array to keep track of it
        // and to prevent registering it again
        $this->managers[$managerClass] = $managerInstance;

        // Register the manager as a singleton in the container
        // so we can resolve it later on the application
        // $this->singleton($managerClass, $managerInstance);
    }
}
