<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use Angelej\PhpInsider\Sinks\Sink;
use PhpParser\Node;
use PhpParser\Node\Expr\Eval_;

class EvalSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if ($node instanceof Eval_) {
            $level = Level::ZERO;

            if (NodeHelper::isDynamic($node)) {
                $level = Level::ONE;
            }
        }

        return $level;
    }
}
