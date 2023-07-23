<?php

namespace Angelej\PhpInsider\Sinks;

use PhpParser\Node;
use PhpParser\NodeFinder;
use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Report;
use PhpParser\NodeVisitorAbstract;

abstract class Sink extends NodeVisitorAbstract {

    /**
     * @var \Angelej\PhpInsider\Report
     */
    protected Report $report;

    /**
     * @var \Angelej\PhpInsider\File
     */
    protected File $file;

    /**
     * @var \PhpParser\NodeFinder
     */
    protected NodeFinder $nodeFinder;

    /**
     * @param  \Angelej\PhpInsider\File $file
     */
    public function __construct(File $file){

        $this->file = $file;
        $this->nodeFinder = new NodeFinder();
        $this->report = Report::getInstance();
    }

    /**
     * @param  \PhpParser\Node $node
     * @return void
     */
    protected function report(Node $node): void {

        $this->report->add($this->file, $this, $node);
    }
}