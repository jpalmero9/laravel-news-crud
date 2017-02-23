<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

/**
 * Class CategoryEditRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class CategoryEditRequest extends CategoryCreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->getRules(), ['id' => 'required|integer']);
    }

    /**
     * @return array|\Symfony\Component\Translation\TranslatorInterface
     */
    public function messages()
    {
        return array_merge(trans('news::category.validate_messages.create'),
            trans('news::category.validate_messages.update'));
    }
}
