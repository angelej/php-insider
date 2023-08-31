<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use PhpParser\Node;
use Angelej\PhpInsider\Level;
use PhpParser\Node\Expr\Eval_;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class EvalSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return \Angelej\PhpInsider\Level|null
     */
    public static function is(Node $node): ?Level {

        $level = null;

        if($node instanceof Eval_){

            $level = Level::ZERO;

            if(NodeHelper::isDynamic($node)){
                $level = Level::ONE;
            }
        }
        return $level;
    }
}