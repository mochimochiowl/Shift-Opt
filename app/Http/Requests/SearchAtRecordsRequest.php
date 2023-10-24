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
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'keyword.max' => 'キーワードは:max文字以下で入力してください。',
            'search_field.required' => '検索種別を選択してください。',
            'start_date.required' => '開始日を入力して下さい',
            'end_date.required' => '終了日を入力して下さい',
            'start_date.date_format' => '開始日はYYYY-MM-DDの形式で入力して下さい',
            'end_date.date_format' => '終了日はYYYY-MM-DDの形式で入力して下さい',
        ];
    }
}
