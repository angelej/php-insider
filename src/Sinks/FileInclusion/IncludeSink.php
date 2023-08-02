<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileInclusion;

use PhpParser\Node;
use PhpParser\Node\Expr\Include_;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class IncludeSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return $node instanceof Include_ && NodeHelper::isDynamic($node);
    }
}