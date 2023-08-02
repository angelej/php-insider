<?php

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use PhpParser\Node;
use PhpParser\Node\Expr\Eval_;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class EvalSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return $node instanceof Eval_ && NodeHelper::isDynamic($node);
    }
}