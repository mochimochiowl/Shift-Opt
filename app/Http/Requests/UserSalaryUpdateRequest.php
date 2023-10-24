<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

class UserSalaryUpdateRequest extends FormRequest
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
            ConstParams::HOURLY_WAGE => 'required|numeric|min:0|max:99999.99',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => ':attributeを入力してください。',
            'email' => ConstParams::EMAIL_JP . 'の形式が正しくありません。',
            'min' => ':attributeは最低:min' . ConstParams::CURRENCY_JP . 'から設定可能です。',
            'max' => ':attributeは最大:max' . ConstParams::CURRENCY_JP . 'まで設定可能です。',
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            ConstParams::HOURLY_WAGE => ConstParams::HOURLY_WAGE_JP,
        ];
    }
}
