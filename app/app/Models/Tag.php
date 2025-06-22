<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes; // deleted_at を使用するため

    protected $table = 'tag';

    protected $primaryKey = 'tag_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'tag_id',
        'tag_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function routineTags(): HasMany
    {
        return $this->hasMany(RoutineTag::class, 'tag_id', 'tag_id');
    }
}
