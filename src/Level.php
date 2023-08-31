<?php

namespace Angelej\PhpInsider;

enum Level: int {

    CASE ZERO = 0;
    CASE ONE = 1;

    /** @return \Angelej\PhpInsider\Level */
    public static function min(): self {

        return self::ZERO;
    }

    /** @return \Angelej\PhpInsider\Level */
    public static function max(): self {

        return self::ONE;
    }
}