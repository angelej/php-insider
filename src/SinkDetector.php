<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use PhpParser\Node;
use Angelej\PhpInsider\Sinks;
use PhpParser\NodeVisitorAbstract;

class SinkDetector extends NodeVisitorAbstract {

    /**
     * @var array|string[]
     */
    protected array $sinks = [
        Sinks\CodeExecution\BacktickSink::class,
        Sinks\CodeExecution\EvalSink::class,
        Sinks\CodeExecution\ExecSink::class,
        Sinks\CodeExecution\PassthruSink::class,
        Sinks\CodeExecution\PcntlExecSink::class,
        Sinks\CodeExecution\PopenSink::class,
        Sinks\CodeExecution\ProcOpenSink::class,
        Sinks\CodeExecution\ShellExecSink::class,
        Sinks\CodeExecution\SystemSink::class,
        Sinks\FileInclusion\IncludeSink::class,
        Sinks\FileRead\FileGetContentsSink::class,
        Sinks\FileRead\FileSink::class,
        Sinks\FileRead\ReadfileSink::class,
        Sinks\FileWrite\CopySink::class,
        Sinks\FileWrite\FilePutContentsSink::class,
        Sinks\InformationDisclosure\PhpinfoSink::class
    ];

    /**
     * @var \Angelej\PhpInsider\Location
     */
    protected Location $currentLocation;

    /**
     * @var \Angelej\PhpInsider\Report
     */
    protected Report $report;

    public function __construct(){

        $this->report = Report::getInstance();
    }

    /**
     * @param  \PhpParser\Node $node
     * @return \PhpParser\Node
     */
    public function enterNode(Node $node): Node {

        $this->currentLocation->setNode($node);

        foreach($this->sinks as $sinkName){

            if($sinkName::is($node)){

                $sink = new $sinkName(clone $this->currentLocation);
                $this->report->add($sink);
            }
        }
        return $node;
    }

    /**
     * @param  \PhpParser\Node $node
     * @return \PhpParser\Node
     */
    public function leaveNode(Node $node): Node {

        switch(true){
            // leave class node
            case $this->currentLocation->getClassNode() === $node:
                $this->currentLocation->setClassNode(null);
                break;

            // leave method node
            case $this->currentLocation->getMethodNode() === $node:
                $this->currentLocation->setMethodNode(null);
                break;

            // leave function node
            case $this->currentLocation->getFunctionNode() === $node:
                $this->currentLocation->setFunctionNode(null);
                break;
        }
        return $node;
    }

    /**
     * @param  \Angelej\PhpInsider\Location $location
     * @return $this
     */
    public function setLocation(Location $location): self {

        $this->currentLocation = $location;
        return $this;
    }
}