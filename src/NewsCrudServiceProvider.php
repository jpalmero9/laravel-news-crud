<?php

namespace Sevenpluss\NewsCrud;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class NewsCrudServiceProvider
 * @package Sevenpluss\NewsCrud
 */
class NewsCrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '../../config/translatable.php';
        $this->publishes([$configPath => config_path('translatable.php')], 'translatable');
        $this->mergeConfigFrom($configPath, 'translatable');


        $this->publishes([
            __DIR__ . '../../resources/lang' => resource_path('lang/vendor/news'),
        ], 'lang');
        $this->loadTranslationsFrom(__DIR__ . '../../resources/lang', 'news');


        $this->publishes([
            __DIR__ . '../../resources/assets' => public_path('vendor/news-crud'),
        ], 'assets');


        $this->publishes([
            __DIR__ . '../../resources/views' => resource_path('views/vendor/news'),
        ], 'views');
        $this->loadViewsFrom(__DIR__ . '../../resources/views', 'news');


        $this->publishes([
            __DIR__ . '../../database' => database_path(),
        ], 'database');
        $this->loadMigrationsFrom(__DIR__ . '../../database');



        $routeConfig = [
            'namespace' => 'Sevenpluss\NewsCrud\Http\Controllers',
            'middleware' => ['web'],
        ];

        $this->getRouter()->group($routeConfig, function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });



        $routeConfig = [
            'namespace' => 'Sevenpluss\NewsCrud\Http\Controllers',
            'middleware' => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                'throttle:60,1',
                'bindings',
                'api'
            ],
            'prefix' => 'api/v1'
        ];

        $this->getRouter()->group($routeConfig, function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\TwigBridge\ServiceProvider::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        $loader->alias('Twig', \TwigBridge\Facade\Twig::class);

        Collection::macro('present', function ($class) {
            return $this->map(function ($model) use ($class) {
                return new $class($model);
            });
        });


        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface::class, \Sevenpluss\NewsCrud\Repositories\CategoryRepository::class, true);
        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface::class, \Sevenpluss\NewsCrud\Repositories\TagRepository::class, true);
        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface::class, \Sevenpluss\NewsCrud\Repositories\CommentRepository::class, true);
        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface::class, \Sevenpluss\NewsCrud\Repositories\PostRepository::class, true);
        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface::class, \Sevenpluss\NewsCrud\Repositories\UserRepository::class, true);

    }

    /**
     * @return \Illuminate\Container\Container
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }
}
