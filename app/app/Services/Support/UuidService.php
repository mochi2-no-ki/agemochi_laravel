<?php

namespace App\Services\Support;

use Symfony\Component\Uid\Uuid;

class UuidService
{
    /**
     * UUIDv7を生成する（Symfony\Uid を利用）
     */
    public static function generateV7(): string
    {
        return Uuid::v7()->toRfc4122();
    }
}
