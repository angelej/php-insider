<?php

declare(strict_types=1);

namespace Angelej\PhpInsider;

enum Level: int
{
    case ZERO = 0;
    case ONE = 1;

    public static function min(): self
    {
        return self::ZERO;
    }

    public static function max(): self
    {
        return self::ONE;
    }
}
