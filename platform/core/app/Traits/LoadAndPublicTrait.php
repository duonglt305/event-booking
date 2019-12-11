<?php

namespace DG\Dissertation\Core\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

/**
 * Trait LoadAndPublicTrait
 * @package DG\Dissertation\Core\Traits
 * @mixin ServiceProvider
 */
trait LoadAndPublicTrait
{
    /**
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $basePath;

    /**
     * @param $namespace
     * @return LoadAndPublicTrait
     */
    public function setNamespace($namespace): self
    {
        $this->namespace = trim(ltrim(rtrim($namespace, '\\\/'), '\\\/'));
        return $this;
    }

    /**
     * @return string
     */
    public function getNameSpace()
    {
        return str_replace('\\', '/', $this->namespace);
    }

    /**
     * @return mixed
     */
    public function getDotNamespace()
    {
        return str_replace("\\", '.', str_replace('/', '.', $this->namespace));
    }

    /**
     * @param $basePath
     * @return LoadAndPublicTrait
     */
    public function setBasePath($basePath): self
    {
        $this->basePath = $basePath;
        return $this;
    }


    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath ?? platform_path();
    }

    /**
     * @param string $file
     * @return string
     */
    public function getConfigPath(string $file): string
    {
        return $this->getBasePath() . $this->getNameSpace() . '/config/' . $file . '.php';
    }

    public function getRoutePath($file): string
    {
        return $this->getBasePath() . $this->getNameSpace() . '/routes/' . $file . '.php';
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->getBasePath() . $this->getNameSpace() . '/resources/views';
    }

    /**
     * @return string
     */
    public function getLangPath()
    {
        return $this->getBasePath() . $this->getNameSpace() . '/resources/lang';
    }


    /**
     * @return string
     */
    public function getMigrationPath()
    {
        return $this->getBasePath() . $this->getNameSpace() . '/database/migrations';
    }

    /**
     * Load config of module and merge to app config
     * @param $fileNames
     * @param $path
     * @return LoadAndPublicTrait
     */
    public function loadAndPublicConfigs($fileNames): self
    {
        if (!is_array($fileNames))
            $fileNames = [$fileNames];

        foreach ($fileNames as $fileName) {
            $this->mergeConfigFrom($this->getConfigPath($fileName), $this->getDotNamespace() . '.' . $fileName);
        }
        return $this;
    }

    /**
     * @return LoadAndPublicTrait
     */
    public function loadView(): self
    {
        $this->loadViewsFrom($this->getViewPath(), $this->getDotNamespace());
        return $this;
    }

    /**
     * @return LoadAndPublicTrait
     */
    public function loadLang(): self
    {
        $this->loadTranslationsFrom($this->getLangPath(), $this->getDotNamespace());
        return $this;
    }

    /**
     * @param $fileNames
     * @return $this
     */
    public function loadRoute($fileNames): self
    {
        if (!is_array($fileNames)) {
            $fileNames = [$fileNames];
        }
        foreach ($fileNames as $fileName) {
            $this->loadRoutesFrom($this->getRoutePath($fileName));
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function loadMigration(): self
    {
        $this->loadMigrationsFrom($this->getMigrationPath());
        return $this;
    }

    /**
     * @param $alias
     * @param $class
     * @return $this
     */
    public function applyMiddleware($alias, $class): self
    {
        app()['router']->aliasMiddleware($alias, $class);
        return $this;
    }

    /**
     * @param string $path
     * @throws BindingResolutionException
     */
    protected function registerEloquentFactoriesFrom(string $path)
    {
        $this->app->make(Factory::class)->load($path);
    }

    /**
     * @param string $path
     * @return $this
     * @throws BindingResolutionException
     */
    public function loadFactory(string $path): self
    {
        $this->registerEloquentFactoriesFrom($path);
        return $this;
    }
}
