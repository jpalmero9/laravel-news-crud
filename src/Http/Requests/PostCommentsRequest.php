<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostCommentsRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class PostCommentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'sometimes|integer',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return trans('news::post.comments_loop.validate_messages');
    }
}
