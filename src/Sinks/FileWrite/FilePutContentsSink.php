<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileWrite;

use PhpParser\Node;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class FilePutContentsSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return \Angelej\PhpInsider\Level|null
     */
    public static function is(Node $node): ?Level {

        $level = null;

        if(NodeHelper::isFunctionCall($node, 'file_put_contents')){

            $level = Level::ZERO;

            if(NodeHelper::isDynamic($node->args[0] ?? null)
                || NodeHelper::isDynamic($node->args[1] ?? null)){
                $level = Level::ONE;
            }
        }
        return $level;
    }
}