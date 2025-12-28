<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use PhpParser\Node;

class PutenvSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if (NodeHelper::isFunctionCall($node, 'putenv')) {
            $level = Level::ZERO;

            if (NodeHelper::isDynamic($node->args[0] ?? null)) {
                $level = Level::ONE;
            }
        }

        return $level;
    }
}
