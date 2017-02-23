<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostIndexRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class PostIndexRequest extends FormRequest
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
            'category_id' => 'sometimes|integer|exists:categories,id',
            'author_id' => 'sometimes|integer|exists:users,id',
            'limit' => 'sometimes|integer|max:100',
            'tag' => 'sometimes|string|between:2,20',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return trans('news::post.validate_messages.index');
    }
}
