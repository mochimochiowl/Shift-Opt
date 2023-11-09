<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

/**
 * パスワード更新に関するリクエスト
 * @author mochimochiowl
 * @version 1.0.0
 */
class PasswordUpdateRequest extends FormRequest
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
            ConstParams::USER_ID => 'required|exists:users,user_id',
            ConstParams::UPDATED_BY => 'required',
            'old_pwd' => 'required|min:1|max:20',
            'new_pwd_1' => 'required|min:1|max:20',
            'new_pwd_2' => 'required|min:1|max:20',
        ];
    }

    /**
     * エラーメッセージの配列を返す
     * @return array
     */
    public function messages(): array
    {
        return [

            ConstParams::USER_ID . '.required' => ':attributeが見つかりません。管理者にご連絡ください。',
            ConstParams::UPDATED_BY . '.required' => ':attributeが見つかりません。管理者にご連絡ください。',
            'user_id.exists' => ':attributeが存在しません。管理者にご連絡ください。',
            'required' => ':attributeを入力して下さい。',
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            ConstParams::USER_ID => ConstParams::USER_ID_JP,
            ConstParams::UPDATED_BY => ConstParams::UPDATED_BY_JP,
            'old_pwd' => '現在の' . ConstParams::PASSWORD_JP,
            'new_pwd_1' => '新しい' . ConstParams::PASSWORD_JP,
            'new_pwd_2' => '確認用の欄に新しい' . ConstParams::PASSWORD_JP,
        ];
    }
}
