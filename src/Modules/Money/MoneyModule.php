<?php

declare(strict_types=1);

namespace DDD\Modules\Money;

use DDD\Infrastructure\Modules\DDDModule;

class MoneyModule extends DDDModule
{
    public static function getSourcePath(): string
    {
        return __DIR__ . '/../..';
    }
}
