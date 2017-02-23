<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentCreateRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class CommentCreateRequest extends FormRequest
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
            'post_id' => 'required|integer',
            'user_id' => 'required_without_all:name,email|integer|exists:users,id',
            'name' => 'required_without:user_id|required_with:email|string|min:3|max:50',
            'email' => 'required_without:user_id|required_with:name|email|min:6|max:50',
            'content' => 'required|string|between:3,500',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return trans('news::comments.validate_messages.add');
    }
}
