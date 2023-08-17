<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\InformationDisclosure;

use PhpParser\Node;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class PhpinfoSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return bool
     */
    public static function is(Node $node): bool {

        return NodeHelper::isFunctionCall($node, 'phpinfo');
    }
}