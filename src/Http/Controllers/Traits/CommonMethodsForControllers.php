<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Traits;

use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;

/**
 * Class CommonMethods
 * @package Sevenpluss\NewsCrud\Http\Controllers\Traits
 */
trait CommonMethodsForControllers
{
    /**
     * @var string
     */
    protected $page_name;

    /**
     * @var string|null
     */
    protected $category_name;

    /**
     * @return array
     */
    protected function getMetaDefault()
    {
        return array_merge([
            'og_prefix' => 'og: http://ogp.me/ns#',
            'title' => null,
            'description' => null,
            'keywords' => null,
            'url_current' => app('url')->current(),
            'images' => [
                [
                    'url' => null,
                    'width' => 120,
                    'height' => 120,
                    'type' => 'image/png'
                ]
            ],
            'news' => null,
        ], trans('news::meta'));
    }

    /**
     * @param string $page
     * @return void
     */
    protected function setPageName(string $page)
    {
        $this->page_name = $page;
    }

    /**
     * @return string
     */
    protected function getPageName()
    {
        return $this->page_name;
    }

    /**
     * @param string|null $category
     * @return void
     */
    protected function setCurrentCategoryName(string $category)
    {
        $this->category_name = $category;
    }

    /**
     * @return null|string
     */
    protected function getCurrentCategoryName()
    {
        return $this->category_name;
    }

    /**
     * @return void
     */
    protected function prepareHeaderData()
    {
        view()->composer('news::common.header', function ($view) {

            $categories = $this->getHeaderCategories();

            $user = app('auth')->user();
            $current_category = $this->getCurrentCategoryName();

            return $view->with(compact('current_category', 'categories', 'user'));
        });
    }

    /**
     * @param array $meta
     * @return void
     */
    protected function prepareMetaData(array $meta = [])
    {
        view()->composer('news::common.meta', function ($view) use ($meta) {

            $meta = !empty($meta) ? array_merge($this->getMetaDefault(), $meta) : $this->getMetaDefault();

            return $view->with(compact('meta'));
        });
    }

    /**
     * @param \Illuminate\Support\Collection|array $breadcrumbs
     * @return void
     */
    protected function prepareBreadcrumbData($breadcrumbs)
    {
        view()->composer('news::common.breadcrumb', function ($view) use ($breadcrumbs) {
            return $view->with(compact('breadcrumbs'));
        });
    }

    /**
     * @param string|bool $is_main_page
     * @return void
     */
    protected function prepareTagsData($is_main_page = false)
    {
        view()->composer('news::common.tags_list', function ($view) use ($is_main_page) {

            $tags = $this->getTagsList($is_main_page);

            return $view->with(compact('tags'));
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getHeaderCategories()
    {
        return app()->make(CategoryRepositoryInterface::class)->headerMenu();
    }

    /**
     * @param string|bool $is_main_page
     * @return \Illuminate\Support\Collection
     */
    protected function getTagsList($is_main_page = false)
    {
        return app()->make(TagRepositoryInterface::class)->sidebarList($is_main_page);
    }
}
