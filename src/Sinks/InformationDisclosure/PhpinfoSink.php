<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks\InformationDisclosure;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\NodeHelper;
use Angelej\PhpInsider\Sinks\Sink;
use PhpParser\Node;

class PhpinfoSink extends Sink
{
    public static function is(Node $node): ?Level
    {
        $level = null;

        if (NodeHelper::isFunctionCall($node, 'phpinfo')) {
            $level = Level::max();
        }

        return $level;
    }
}
