<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Sevenpluss\NewsCrud\Models\Category;
use Sevenpluss\NewsCrud\Presenters\CategoryPresenter;

/**
 * Class CategoryRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Category
     */
    protected $repository;

    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function paginate(int $limit = 10)
    {
        return $this->repository->select(['id', 'slug', 'name', 'active'])
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headerMenu()
    {
        return $this->repository->active()
            ->get(['id', 'slug', 'name'])
            ->present(CategoryPresenter::class)
            ->map(function (CategoryPresenter $category) {
                return [
                    'name' => $category->getName(),
                    'slug' => $category->getSlug(),
                    'url' => $category->getUri(),
                ];
            });
    }

    /**
     * @param int $category_id
     * @return null|string
     */
    public function getCategoryNameByID(int $category_id)
    {
        return $this->repository->where('id', $category_id)->get(['name'])->pluck('name')->first();
    }

    /**
     * @param string $slug
     * @return null|array
     */
    public function getCategoryDataBySlug(string $slug)
    {
        $category = new CategoryPresenter(
            $this->repository->select(['id', 'name'])
                ->where('slug', $slug)
                ->firstOrFail()
        );

        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllForPostEdit()
    {
        return $this->repository->orderBy('updated_at', 'desc')
            ->get(['id', 'name'])
            ->present(CategoryPresenter::class)
            ->map(function (CategoryPresenter $category) {
                return [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                ];
            });
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getDataForEdit(int $id)
    {
        return $this->repository->select([
            'id',
            'slug',
            'name',
            'active'
        ])
            ->where('id', $id)
            ->orderBy('updated_at', 'desc')
            ->firstOrFail();
    }

}
