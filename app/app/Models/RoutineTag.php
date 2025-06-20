<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineTag extends Model
{
    protected $table = 'routine_tag';

    protected $primaryKey = 'routine_tag_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'routine_tag_id',
        'routine_id',
        'tag_id',
        'created_at',
    ];

    /**
     * ルーティーンとのリレーション
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class, 'routine_id', 'routine_id');
    }

    /**
     * タグとのリレーション
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'tag_id');
    }
}
