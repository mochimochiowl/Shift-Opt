<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

class StampRequest extends FormRequest
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
            'target_login_id' => 'required|exists:users,login_id',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [
            'target_login_id' . '.required' => ConstParams::LOGIN_ID_JP . 'を入力して下さい。',
            'target_login_id' . '.exists' => ConstParams::LOGIN_ID_JP . 'が存在しません。',
        ];
    }
}
