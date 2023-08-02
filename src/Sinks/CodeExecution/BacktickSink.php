<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\CodeExecution;

use PhpParser\Node;
use PhpParser\Node\Expr\ShellExec;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class BacktickSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return $node instanceof ShellExec && NodeHelper::isDynamic($node);
    }
}