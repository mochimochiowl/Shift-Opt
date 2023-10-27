<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

/**
 * 打刻レコードの更新に関するリクエスト
 * @author mochimochiowl
 * @version 1.0.0
 */
class AtRecordUpdateRequest extends FormRequest
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
            ConstParams::AT_SESSION_ID =>  ['required', 'size:36', 'regex:/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/'],
            ConstParams::AT_RECORD_TYPE => 'required',
            ConstParams::AT_RECORD_DATE => 'required|date_format:Y-m-d',
            ConstParams::AT_RECORD_TIME => 'required',
            'logged_in_user_name' => 'required',
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
            'min' => ':attributeは最低:min文字以上です。',
            'max' => ':attributeは最大:max文字までです。',
            'exists' => ':attributeが存在しません。',
            ConstParams::AT_SESSION_ID . '.size' => ':attributeは、:size文字で入力して下さい。',
            ConstParams::AT_SESSION_ID . '.regex' => ':attributeは、uuidの形式(8-4-4-4-12)で入力して下さい。',
            ConstParams::AT_SESSION_ID . '.date_format' => ':attributeはYYYY-MM-DDの形式で入力して下さい',
            'logged_in_user_name' . '.required' => 'ログイン済ユーザーのユーザー名を取得できません。（管理者にご連絡ください。）',
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            ConstParams::AT_SESSION_ID => ConstParams::AT_SESSION_ID_JP,
            ConstParams::AT_RECORD_TYPE => ConstParams::AT_RECORD_TYPE_JP,
            ConstParams::AT_RECORD_DATE => ConstParams::AT_RECORD_DATE_JP,
            ConstParams::AT_RECORD_TIME => ConstParams::AT_RECORD_TIME_JP,
            'logged_in_user_name' => 'ログインユーザー名',
        ];
    }
}
