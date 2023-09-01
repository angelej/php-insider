<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks;

use PhpParser\Node;
use Angelej\PhpInsider\Level;

interface SinkInterface {

    /**
     * @param  \PhpParser\Node $node
     * @return \Angelej\PhpInsider\Level|null
     */
    public static function is(Node $node): ?Level;
}