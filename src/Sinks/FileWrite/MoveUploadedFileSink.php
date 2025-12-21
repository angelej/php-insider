<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileWrite;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use Angelej\PhpInsider\Sinks\Sink;
use PhpParser\Node;

class MoveUploadedFileSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if (NodeHelper::isFunctionCall($node, 'move_uploaded_file')) {
            $level = Level::ZERO;

            if (NodeHelper::isDynamic($node)) {
                $level = Level::ONE;
            }
        }

        return $level;
    }
}
