<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use PhpParser\Node;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class PopenSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return \Angelej\PhpInsider\Level|null
     */
    public static function is(Node $node): ?Level {

        $level = null;

        if(NodeHelper::isFunctionCall($node, 'popen')){

            $level = Level::ZERO;

            if(NodeHelper::isDynamic($node->args[0] ?? null)){
                $level = Level::ONE;
            }
        }
        return $level;
    }
}