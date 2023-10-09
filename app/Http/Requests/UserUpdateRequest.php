<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            ConstParams::KANJI_LAST_NAME => 'required',
            ConstParams::KANJI_FIRST_NAME => 'required',
            ConstParams::KANA_LAST_NAME => 'required',
            ConstParams::KANA_FIRST_NAME => 'required',
            ConstParams::EMAIL => 'required|email',
            ConstParams::LOGIN_ID => 'required',
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
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            ConstParams::KANJI_LAST_NAME => ConstParams::KANJI_LAST_NAME_JP,
            ConstParams::KANJI_FIRST_NAME => ConstParams::KANJI_FIRST_NAME_JP,
            ConstParams::KANA_LAST_NAME => ConstParams::KANA_LAST_NAME_JP,
            ConstParams::KANA_FIRST_NAME => ConstParams::KANA_FIRST_NAME_JP,
            ConstParams::EMAIL => ConstParams::EMAIL_JP,
            ConstParams::LOGIN_ID => ConstParams::LOGIN_ID_JP,
            ConstParams::PASSWORD => ConstParams::PASSWORD_JP,
        ];
    }
}
