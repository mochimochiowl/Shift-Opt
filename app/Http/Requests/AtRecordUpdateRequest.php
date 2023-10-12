<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

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
            ConstParams::AT_RECORD_TYPE => 'required',
            'at_record_time_date' => 'required',
            'at_record_time_time' => 'required',
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
            ConstParams::AT_RECORD_TYPE => ConstParams::AT_RECORD_TYPE_JP,
            'at_record_time_date' => '日付',
            'at_record_time_time' => '時刻',
            'logged_in_user_name' => 'ログインユーザー名が空欄です',
        ];
    }
}
