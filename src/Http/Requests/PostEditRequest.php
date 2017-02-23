<?php

namespace Sevenpluss\NewsCrud\Http\Requests;

/**
 * Class PostEditRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class PostEditRequest extends PostCreateRequest
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
        return array_merge(trans('news::post.validate_messages.create'), trans('news::post.validate_messages.update'));
    }
}
