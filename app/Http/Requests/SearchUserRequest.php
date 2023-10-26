<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
{
    /**
     * このアクションが現在のユーザーに許可されているかどうか
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルールの配列を返す
     * @return array
     */
    public function rules(): array
    {
        return [
            'keyword' => 'max:200',
            'search_field' => 'required',
            'column' => 'required',
            'order' => 'required',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'max' => ':attributeは:max文字以下で入力してください。',
            'required' => ':attributeを入力してください。',
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            'keyword' => 'キーワード',
            'search_field' => '検索種別',
            'column' => '整列の対象カラム',
            'order' => '整列順序',
        ];
    }
}
