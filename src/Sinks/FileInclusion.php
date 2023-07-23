<?php

namespace Angelej\PhpInsider\Sinks;

use PhpParser\Node;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Expr\Variable;

class FileInclusion extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return void
     */
    public function leaveNode(Node $node): void {

        /**
         * Find all include / require (include_once, require_once) statements
         * which have at least one dynamic variable.
         */
        if($node instanceof Include_){

            $variables = $this->nodeFinder->findInstanceOf($node, Variable::class);

            if(count($variables) > 0){

                $this->report($node);
            }
        }
    }
}