<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Sevenpluss\NewsCrud\Http\Requests\PostIndexRequest;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sevenpluss\NewsCrud\Repositories\PostRepository;
use Sevenpluss\NewsCrud\Repositories\CategoryRepository;
use Sevenpluss\NewsCrud\Exceptions\NoContentException;

/**
 * Class PostController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class PostController extends RootApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param PostIndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     * @throws NoContentException
     */
    public function paginationNews(PostIndexRequest $request)
    {
        $this->setApiLocale($request);

        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            $response['status'] = 'OK';

            $response['results'] = app()->make(PostRepositoryInterface::class)->newsPaginate(
                $request->input('limit', 10),
                $request->input('page', 1),
                $request->input('category_id'),
                $request->input('author_id'),
                $request->input('tag')
            );

            if ($response['results']->isEmpty()) {
                throw new NoContentException;
            }

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } catch (NoContentException $e) {

            $response['message'] = $e->getMessage();
            $statusCode = $e->getCode();

        } finally {
            return Response::json($response, $statusCode);
        }
    }

    /**
     * @param PostIndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     * @throws NoContentException
     */
    public function paginationCategory(
        PostIndexRequest $request
    ) {
        $this->setApiLocale($request);

        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            $response['status'] = 'OK';

            $response['results'] = app()->make(PostRepositoryInterface::class)->categoryPaginate(
                $request->input('limit', 10),
                $request->input('page', 1),
                $request->input('category_id'),
                $request->input('author_id'),
                $request->input('tag'),
//                $categoryRepo->findByKey('id', $request->input('category_id'))->pluck('slug')->first()
                app()->make(CategoryRepositoryInterface::class)->findByKey('id', $request->input('category_id'))->pluck('slug')->first()
            );

            if ($response['results']->isEmpty()) {
                throw new NoContentException;
            }

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } catch (NoContentException $e) {

            $response['message'] = $e->getMessage();
            $statusCode = $e->getCode();

        } finally {
            return Response::json($response, $statusCode);
        }
    }

    /**
     * @param PostIndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     * @throws NoContentException
     */
    public function paginationTags(PostIndexRequest $request)
    {
        $this->setApiLocale($request);

        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            $response['status'] = 'OK';

            $response['results'] = app()->make(PostRepositoryInterface::class)->tagsPaginate(
                $request->input('route', 'tags.index'),
                $request->input('limit', 10),
                $request->input('page', 1),
                $request->input('category_id'),
                $request->input('author_id'),
                $request->input('tag')
            );

            if ($response['results']->isEmpty()) {
                throw new NoContentException;
            }

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } catch (NoContentException $e) {

            $response['message'] = $e->getMessage();
            $statusCode = $e->getCode();

        } finally {
            return Response::json($response, $statusCode);
        }
    }

    /**
     * @param Request $request
     * @param PostRepository $postRepo
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function destroy(Request $request, PostRepository $postRepo)
    {
        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            if ($request->has('id')) {

                app()->make(PostRepositoryInterface::class)->destroy($request->input('id'));

                $response['status'] = 'OK';
            }

        } catch (BadRequestHttpException | HttpException $e) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            $statusCode = $e->getCode();

        } finally {
            return Response::json($response, $statusCode);
        }
    }

}
