<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * サマリー画面の表示に関するリクエスト
 * @author mochimochiowl
 * @version 1.0.0
 */
class SummaryRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'date.required' => '対象日を入力して下さい',
        ];
    }
}
