<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileRead;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use Angelej\PhpInsider\Sinks\Sink;
use PhpParser\Node;

class FreadSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if (NodeHelper::isFunctionCall($node, 'fread')) {
            $level = Level::max();
        }

        return $level;
    }
}
