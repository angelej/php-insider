<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileRead;

use PhpParser\Node;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class ReadfileSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return NodeHelper::isFunctionCall($node, 'readfile')
            && NodeHelper::isDynamic($node->args[0] ?? null);
    }
}