<?php


namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentsLatestRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class CommentsLatestRequest extends FormRequest
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
            'limit' => 'required|integer',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return trans('news::comments.validate_messages.latest');
    }
}
