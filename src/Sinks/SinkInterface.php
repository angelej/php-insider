<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks;

use PhpParser\Node;

interface SinkInterface {

    public static function is(Node $node): bool;
}