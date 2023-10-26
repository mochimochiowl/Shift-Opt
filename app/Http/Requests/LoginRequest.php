<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            ConstParams::LOGIN_ID => 'required|exists:users,login_id',
            ConstParams::PASSWORD => 'required',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => ':attributeを入力して下さい。',
            'exists' => ':attributeが存在しません。',
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            ConstParams::LOGIN_ID => ConstParams::LOGIN_ID_JP,
            ConstParams::PASSWORD => ConstParams::PASSWORD_JP,
        ];
    }
}
