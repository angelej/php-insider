<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\FileInclusion;

use PhpParser\Node;
use Angelej\PhpInsider\Level;
use PhpParser\Node\Expr\Include_;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class IncludeSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return \Angelej\PhpInsider\Level|null
     */
    public static function is(Node $node): ?Level {

        $level = null;

        if($node instanceof Include_){

            $level = Level::ZERO;

            if(NodeHelper::isDynamic($node)){
                $level = Level::ONE;
            }
        }
        return $level;
    }
}