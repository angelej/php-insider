<?php

namespace Angelej\PhpInsider\Sinks;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\Eval_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\ShellExec;

class CodeExecution extends Sink {

    /**
     * @param  \PhpParser\Node $node
     * @return void
     */
    public function leaveNode(Node $node): void {

        /**
         * Find all eval(), system(), exec() and backticks statements
         * which have at least one dynamic variable.
         */
        if($node instanceof Eval_
            || $node instanceof ShellExec
            || $this->isSystemNode($node)
            || $this->isExecNode($node)
        ){

            $variables = $this->nodeFinder->findInstanceOf($node, Variable::class);

            if(count($variables) > 0){

                $this->report($node);
            }
        }
    }

    /**
     * Check if $node is system() token
     *
     * @param  \PhpParser\Node $node
     * @return bool
     */
    private function isSystemNode(Node $node): bool {

        $isSystemNode = false;

        if($node instanceof FuncCall){

            if(($name = $node?->name) instanceof Name){

                $isSystemNode = $name->getFirst() === 'system';
            }
        }
        return $isSystemNode;
    }

    /**
     * Check if $node is exec() token
     *
     * @param  \PhpParser\Node $node
     * @return bool
     */
    private function isExecNode(Node $node): bool {

        $isExecNode = false;

        if($node instanceof FuncCall){

            if(($name = $node?->name) instanceof Name){

                $isExecNode = $name->getFirst() === 'exec';
            }
        }
        return $isExecNode;
    }
}