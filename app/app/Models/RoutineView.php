<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineView extends Model
{
    protected $table = 'routine_view';

    protected $primaryKey = 'routine_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'routine_id',
        'reference_count',
        'view_count',
        'created_at',
        'updated_at',
    ];

    /**
     * ルーティーンとのリレーション
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class, 'routine_id', 'routine_id');
    }
}
