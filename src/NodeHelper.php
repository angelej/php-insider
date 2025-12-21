<?php

declare(strict_types=1);

namespace Angelej\PhpInsider;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\NodeFinder;

class NodeHelper
{
    /**
     * @todo   check for \PhpParser\Node\VariadicPlaceholder
     */
    public static function isDynamic(?Node $node): bool
    {
        return (bool) (new NodeFinder)->findFirstInstanceOf([$node], Variable::class);
    }

    public static function isFunctionCall(Node $node, ?string $name = null): bool
    {
        $is = false;

        if ($node instanceof FuncCall) {
            if ($name) {
                $is = $node->name instanceof Name && $node->name->getFirst() === $name;
            } else {
                $is = true;
            }
        }

        return $is;
    }
}
