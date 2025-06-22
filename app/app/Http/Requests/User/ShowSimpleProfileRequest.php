<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ShowSimpleProfileRequest extends FormRequest
{
    /**
     * パスパラメータをバリデーション対象に含める
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'mochi_id' => $this->route('mochi_id'),
        ]);
    }

    /**
     * 認可ロジック（全ユーザーに許可）
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
            'mochi_id' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9_-]+$/'],
        ];
    }

    /**
     * エラーメッセージ定義（任意：日本語対応）
     */
    public function messages(): array
    {
        return [
            'mochi_id.*' => '不正なmochi_idです。',
        ];
    }
}
