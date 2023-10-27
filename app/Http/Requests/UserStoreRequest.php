<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

/**
 * ユーザーの作成に関するリクエスト
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserStoreRequest extends FormRequest
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
            ConstParams::KANJI_LAST_NAME => 'required|min:1|max:15',
            ConstParams::KANJI_FIRST_NAME => 'required|min:1|max:15',
            ConstParams::KANA_LAST_NAME => 'required|min:1|max:15',
            ConstParams::KANA_FIRST_NAME => 'required|min:1|max:15',
            ConstParams::EMAIL => 'required|email|min:3|max:200',
            ConstParams::LOGIN_ID => 'required|min:1|max:20',
            ConstParams::PASSWORD => 'required|min:1|max:20',
            ConstParams::IS_ADMIN => 'required',
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
            'min' => ':attributeは最低:min文字にしてください。',
            'max' => ':attributeは最大:max文字までです。',
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
            ConstParams::IS_ADMIN => ConstParams::IS_ADMIN_JP,
        ];
    }
}
