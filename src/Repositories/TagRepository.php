<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface;
use Sevenpluss\NewsCrud\Presenters\TagPresenter;
use Sevenpluss\NewsCrud\Models\Tag;

/**
 * Class CategoryRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    /**
     * @var \Sevenpluss\NewsCrud\Models\Tag
     */
    protected $repository;

    /**
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    /**
     * @param string|bool $is_main_page
     * @return \Illuminate\Support\Collection
     */
    public function sidebarList($is_main_page = false)
    {
        return $this->repository->whereHas('posts', function (Builder $query){
            $query->select(['id']);
        })->active()->orderBy('updated_at', 'desc')
            ->get(['slug', 'name'])
            ->present(TagPresenter::class)
            ->map(function (TagPresenter $tag) use ($is_main_page) {
                return [
                    'slug' => $tag->getSlug(),
                    'url' => $tag->getUriForBox($is_main_page),
                    'name' => $tag->getName(),
                ];
            });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAllForPostEdit()
    {
        return $this->repository->get(['slug', 'name'])
            ->present(TagPresenter::class)
            ->map(function (TagPresenter $tag) {
                return [
                    'slug' => $tag->getSlug(),
                    'name' => $tag->getName(),
                ];
            });
    }

    /**
     * @param int $post_id
     * @return  \Illuminate\Support\Collection
     */
    public function getSlugsForPost(int $post_id)
    {
        return $this->repository->leftJoin('post_tags', 'post_tags.tag_slug', '=', 'tags.slug')
            ->where('post_tags.post_id', $post_id)->get(['tags.slug'])->pluck('slug');
    }
}
