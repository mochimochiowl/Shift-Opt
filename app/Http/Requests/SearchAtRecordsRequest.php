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
            'search_field' => 'required',
            'keyword' => '',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'search_field.required' => '検索種別を選択してください。',
            'start_date' => '開始日を入力して下さい',
            'end_date' => '終了日を入力して下さい',
        ];
    }
}
