<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model
{
    protected $table = 'message_type';

    protected $primaryKey = 'message_type_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'message_type_id',
        'message_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
