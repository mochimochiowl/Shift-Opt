<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

/**
 * 時給データの更新に関するリクエスト
 * @author mochimochiowl
 * @version 1.0.0
 */
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
            ConstParams::HOURLY_WAGE => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
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
            'regex' => ':attributeの値は、整数部分は6桁まで、小数は第2位までに設定してください。',
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
