<?php

namespace App\Http\Requests\Routine;

use Illuminate\Foundation\Http\FormRequest;

class HoldEventRequest extends FormRequest
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
            'user_id' => ['required', 'string', 'uuid'],
            'start_time' => ['required', 'date_format:Y-m-d H:i'],
            'end_time' => ['required', 'date_format:Y-m-d H:i', 'after:start_time'],
        ];
    }

    /**
     * エラーメッセージ定義（日本語対応）
     */
    public function messages(): array
    {
        return [
            'routine_id.*' => '不正な routine_id です。',
            'user_id.*' => '不正な user_id です。',
            'start_time.required' => '開始時刻は必須です。',
            'start_time.date_format' => '開始時刻の形式は Y-m-d H:i で指定してください（秒は不要です）。',
            'end_time.required' => '終了時刻は必須です。',
            'end_time.date_format' => '終了時刻の形式は Y-m-d H:i で指定してください（秒は不要です）。',
            'end_time.after' => '終了時刻は開始時刻より後でなければなりません。',
        ];
    }
}
