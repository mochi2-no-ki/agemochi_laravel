<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RealtimeStatus extends Model
{
    use SoftDeletes;

    protected $table = 'realtime_status';

    protected $primaryKey = 'realtime_status_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'realtime_status_id',
        'realtime_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
