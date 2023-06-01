<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'post_category_id' => 'required|exists:sub_categories,id',
            'post_title' => 'required|string|min:4|max:100',
            'post_body' => 'required|string|min:10|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'post_category_id.required' => ':attributeは必須項目です',
            'post_category_id.exists' => '存在しない:attributeです',
            'post_title.required' => ':attributeは必須項目です',
            'post_title.min' => ':attributeは4文字以上入力してください',
            'post_title.max' => ':attributeは100文字以内で入力してください',
            'post_body.required' => ':attributeは必須項目です',
            'post_body.min' => ':attributeは10文字以上入力してください',
            'post_body.max' => ':attributeは5000文字以内で入力してください',
        ];
    }

    public function attributes()
    {
        return [
            'post_category_id' => 'カテゴリー',
            'post_title' => 'タイトル',
            'post_body' => '投稿内容',
        ];
    }
}
