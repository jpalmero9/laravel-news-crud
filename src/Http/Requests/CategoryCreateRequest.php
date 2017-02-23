<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryCreateRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class CategoryCreateRequest extends FormRequest
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
            'active' => 'sometimes|boolean',
            'slug' => ['sometimes', 'string', 'max:70', 'regex:/^[0-9a-zA-Z\-]+/'],

            'name' => 'required|max:100',
        ];
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function messages()
    {
        return trans('news::category.validate_messages.create');
    }
}
