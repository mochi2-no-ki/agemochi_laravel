<?php

namespace App\Http\Requests\Routine;

use Illuminate\Foundation\Http\FormRequest;

class ShowRoutineDetailRequest extends FormRequest
{
    /**
     * パスパラメータをバリデーション対象に含める
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'routine_id' => $this->route('routine_id'),
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
            'routine_id' => ['required', 'string', 'uuid'],
        ];
    }

    /**
     * エラーメッセージ定義（任意：日本語対応）
     */
    public function messages(): array
    {
        return [
            'routine_id.*' => '不正な routine_id です。',
        ];
    }
}
