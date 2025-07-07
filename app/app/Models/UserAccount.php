<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function userLogin(): HasOne
    {
        return $this->hasOne(UserLogin::class, 'user_id', 'user_id');
    }

    public function userSave(): HasOne
    {
        return $this->hasOne(UserSave::class, 'user_id', 'user_id');
    }

    public function routine(): HasMany
    {
        return $this->hasMany(Routine::class, 'user_id', 'user_id');
    }

    public function routineSaves(): HasMany
    {
        return $this->hasMany(RoutineSave::class, 'user_id', 'user_id');
    }

    public function realtimeRoutineSaves(): HasMany
    {
        return $this->hasMany(RealtimeRoutineSave::class, 'user_id', 'user_id');
    }

    public function realtimeRoutines(): HasMany
    {
        return $this->hasMany(RealtimeRoutine::class, 'owner_user_id', 'user_id');
    }

    public function realtimeRoutineParticipants(): HasMany
    {
        return $this->hasMany(RealtimeRoutineParticipant::class, 'user_id', 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id', 'user_id');
    }

    public function repliedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'reply_user_id', 'user_id');
    }

    // リレーション例（あとで必要に応じて）
    // public function banner()
    // {
    //     return $this->belongsTo(Banner::class, 'current_user_banner_id', 'banner_id');
    // }
}
