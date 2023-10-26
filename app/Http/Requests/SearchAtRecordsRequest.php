<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAtRecordsRequest extends FormRequest
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
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
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
            'search_field.required' => ':attributeを選択してください。',
            'date_format' => ':attributeはYYYY-MM-DDの形式で入力して下さい',
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
            'start_date' => '開始日',
            'end_date' => '終了日',
            'column' => '整列の対象カラム',
            'order' => '整列順序',
        ];
    }
}
