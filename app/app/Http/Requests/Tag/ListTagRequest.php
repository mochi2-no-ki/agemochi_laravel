<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class ListTagRequest extends FormRequest
{
    /**
     * 認証の許可（全ユーザーに許可）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール定義
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * バリデーションメッセージ（任意だが日本語で定義）
     */
    public function messages(): array
    {
        return [
            'search.string' => '検索キーワードは文字列で指定してください。',
            'search.max' => '検索キーワードは50文字以内で入力してください。',
        ];
    }
}
