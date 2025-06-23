<?php

namespace App\Http\Requests\Routine;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoutineRequest extends FormRequest
{
    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid'],
            'routine_title' => ['required', 'string', 'max:255'],
            'routine_start' => ['required', 'date_format:H:i'],
            'routine_end' => ['required', 'date_format:H:i'],
            'routine_time' => ['required', 'integer', 'min:1'],
            'routine_body' => ['nullable', 'string'],
            'realtime_routine_flag' => ['required', 'boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*.tag_id' => ['nullable', 'uuid'],
        ];
    }

    /**
     * 認可（今回は常に許可）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 属性名（エラーメッセージ用）
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'ユーザーID',
            'routine_title' => 'ルーティーンタイトル',
            'routine_start' => 'ルーティーン開始時刻',
            'routine_end' => 'ルーティーン終了時刻',
            'routine_time' => 'ルーティーン所要時間',
            'routine_body' => 'ルーティーン本文',
            'realtime_routine_flag' => 'リアルタイムルーティーンフラグ',
            'tags' => 'タグ一覧',
            'tags.*.tag_id' => 'タグID',
        ];
    }
}
