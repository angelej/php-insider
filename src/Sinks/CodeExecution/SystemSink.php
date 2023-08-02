<?php

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use PhpParser\Node;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class SystemSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return NodeHelper::isFunctionCall($node, 'system')
            && NodeHelper::isDynamic($node->args[0] ?? null);
    }
}