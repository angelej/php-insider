<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileWrite;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use Angelej\PhpInsider\Sinks\Sink;
use PhpParser\Node;

class FwriteSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if (NodeHelper::isFunctionCall($node, 'fwrite')) {
            $level = Level::ZERO;

            if (NodeHelper::isDynamic($node->args[1] ?? null)) {
                $level = Level::ONE;
            }
        }

        return $level;
    }
}