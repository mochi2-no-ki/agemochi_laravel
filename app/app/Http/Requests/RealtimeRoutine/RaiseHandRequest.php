<?php

namespace App\Http\Requests\RealtimeRoutine;

use Illuminate\Foundation\Http\FormRequest;

class RaiseHandRequest extends FormRequest
{
    /**
     * パスパラメータをバリデーション対象に含める
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'realtime_routine_id' => $this->route('realtime_routine_id'),
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
            'realtime_routine_id' => ['required', 'uuid'],
            'mochi_id' => ['required', 'string'],
        ];
    }
}
