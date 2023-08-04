<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileWrite;

use PhpParser\Node;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class FilePutContentsSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return NodeHelper::isFunctionCall($node, 'file_put_contents')
            && (NodeHelper::isDynamic($node->args[0] ?? null)
                || NodeHelper::isDynamic($node->args[1] ?? null));
    }
}