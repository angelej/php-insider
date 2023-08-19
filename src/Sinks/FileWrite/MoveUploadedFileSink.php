<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileWrite;

use PhpParser\Node;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class MoveUploadedFileSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return NodeHelper::isFunctionCall($node, 'move_uploaded_file')
            && NodeHelper::isDynamic($node);
    }
}