<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

class AtRecordStoreRequest extends FormRequest
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
            ConstParams::AT_RECORD_TYPE => 'required',
            ConstParams::AT_RECORD_DATE => 'required',
            ConstParams::AT_RECORD_TIME => 'required',
            'created_by_user_id' => 'required|exists:users,user_id',
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
            ConstParams::AT_RECORD_TYPE . '.required' => ConstParams::AT_RECORD_TYPE_JP . 'を入力して下さい。',
            ConstParams::AT_RECORD_DATE . '.required' => ConstParams::AT_RECORD_DATE_JP . 'を入力して下さい。',
            ConstParams::AT_RECORD_TIME . '.required' => ConstParams::AT_RECORD_TIME_JP . 'を入力して下さい。',
            'created_by_user_id' . '.required' => 'Error: 管理者IDが空欄です。',
            'created_by_user_id' . '.exists' => 'Error: 管理者IDが存在しません。',
        ];
    }
}
