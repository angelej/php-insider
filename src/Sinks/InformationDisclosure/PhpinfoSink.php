<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\InformationDisclosure;

use PhpParser\Node;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\NodeHelper;

class PhpinfoSink extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return \Angelej\PhpInsider\Level|null
     */
    public static function is(Node $node): ?Level {

        $level = null;

        if(NodeHelper::isFunctionCall($node, 'phpinfo')){

            $level = Level::max();
        }
        return $level;
    }
}