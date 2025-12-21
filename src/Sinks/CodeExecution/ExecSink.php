<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use Angelej\PhpInsider\Sinks\Sink;
use PhpParser\Node;

class ExecSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if (NodeHelper::isFunctionCall($node, 'exec')) {
            $level = Level::ZERO;

            if (NodeHelper::isDynamic($node->args[0] ?? null)) {
                $level = Level::ONE;
            }
        }

        return $level;
    }
}
