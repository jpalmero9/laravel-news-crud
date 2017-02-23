<?php

namespace Sevenpluss\NewsCrud\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class PostController
 * @package Sevenpluss\NewsCrud\Http\Controllers
 */
class CategoryController extends RootApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function destroy(Request $request)
    {
        $response = ['status' => 'error'];

        try {
            $statusCode = 200;

            if ($request->has('id')){

                app()->make(CategoryRepositoryInterface::class)->destroy($request->input('id'));

                $response['status'] = 'OK';
            } else{
                throw new BadRequestHttpException;
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
