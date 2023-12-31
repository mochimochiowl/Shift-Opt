<?php

namespace App\Http\Requests;

use App\Const\ConstParams;
use Illuminate\Foundation\Http\FormRequest;

/**
 * コンディションデータの更新に関するリクエスト
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserConditionUpdateRequest extends FormRequest
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
            ConstParams::HAS_ATTENDED => 'required|boolean',
            ConstParams::IS_BREAKING => 'required|boolean',
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
            'boolean' => ':attributeの型が正しくありません。（管理者にご連絡ください。）',
        ];
    }

    /**
     * 属性名の配列を返す
     * @return array
     */
    public function attributes(): array
    {
        return [
            ConstParams::HAS_ATTENDED => ConstParams::HAS_ATTENDED_JP,
            ConstParams::IS_BREAKING => ConstParams::IS_BREAKING_JP,
        ];
    }
}
