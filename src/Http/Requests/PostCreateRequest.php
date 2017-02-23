<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostCreateRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class PostCreateRequest extends FormRequest
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
        return $this->getRules();
    }

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'user_id' => 'required|integer',
            'published_at' => 'sometimes',
            'published_now' => 'sometimes|boolean',
            'category_id' => 'required|integer',
            'slug' => ['sometimes', 'max:70', 'regex:/^[0-9a-zA-Z\-]+/'],

            'title' => 'sometimes|max:55',
            'description' => 'sometimes|max:155',
            'keywords' => 'sometimes|max:250',
            'name' => 'required|max:255',
            'summary' => 'required|max:1000',
            'story' => 'sometimes|max:5000',

            'tags.*' => 'sometimes|max:20',
        ];
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function messages()
    {
        return trans('news::post.validate_messages.create');
    }
}
