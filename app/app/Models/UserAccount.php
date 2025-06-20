<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'user_account';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'mochi_id',
        'user_name',
        'user_img_path',
        'introduction',
        'current_user_banner_id',
        'current_icon_frame_id',
        'created_at',
        'updated_at',
    ];

    // リレーション例（あとで必要に応じて）
    // public function banner()
    // {
    //     return $this->belongsTo(Banner::class, 'current_user_banner_id', 'banner_id');
    // }
}
