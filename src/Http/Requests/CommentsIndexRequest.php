<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentsIndexRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class CommentsIndexRequest extends FormRequest
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
            'author_id' => 'sometimes|integer|exists:users,id',
            'post_id' => 'sometimes|integer|exists:posts,id',
            'limit' => 'sometimes|integer|max:100'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return trans('news::comments.validate_messages.index');
    }
}
