<?php
    /**
     * A Laravel 5.x wrapper to optimize
     * cache generation
     * @license MIT
     *
     * @link https://kb.apnscp.com/php/working-laravel-config-cache/
     */

    namespace App;

    use Illuminate\Foundation\Application;

    class ApplicationWrapper extends Application
    {

        public function __construct($basePath)
        {
            if (!isset($_SERVER['SITE_ROOT'])) {
                $_SERVER['SITE_ROOT'] = '';
            }
            parent::__construct($basePath);
        }

        /**
         * Fake configuration cache response for CLI
         * as paths will always be different
         *
         * @return bool
         */
        public function configurationIsCached()
        {
            if ($this->runningInConsole()) {
                return false;
            }
            return parent::configurationIsCached();
        }

        /**
         * Emulate \Illuminate\Foundation\Console\ConfigCache\fire()
         *
         * @return bool
         */
        public function doCache()
        {
            if (!$this->runningInConsole()) {
                $config = $this->app['config']->all();
                $this->files->put(
                    $this->getCachedConfigPath(), '<?php return ' . var_export($config, true) . ';' . PHP_EOL
                );
            }
            return true;
        }

        /*
         * Override boot to register production config cache
         * @return boolean
         */
        public function boot()
        {
            parent::boot();

            if (!$this->runningInConsole()) {
                $app = $this->app;
				$app->configurationIsCached() || $app->doCache();
            } else {
                $path = parent::getCachedConfigPath();
                $this->terminating(function () use ($path) {
                    file_exists($path) && unlink($path);
                });
            }

        }
    }