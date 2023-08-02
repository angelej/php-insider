<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Angelej\PhpInsider\Sinks\CodeExecution\EvalSink;
use Angelej\PhpInsider\Sinks\CodeExecution\ExecSink;
use Angelej\PhpInsider\Sinks\CodeExecution\SystemSink;
use Angelej\PhpInsider\Sinks\FileInclusion\IncludeSink;
use Angelej\PhpInsider\Sinks\CodeExecution\BacktickSink;
use Angelej\PhpInsider\Sinks\CodeExecution\PassthruSink;
use Angelej\PhpInsider\Sinks\CodeExecution\ShellExecSink;

class SinkDetector extends NodeVisitorAbstract {

    /**
     * @var array|string[]
     */
    protected array $sinks = [
        BacktickSink::class,
        EvalSink::class,
        ExecSink::class,
        SystemSink::class,
        IncludeSink::class,
        PassthruSink::class,
        ShellExecSink::class
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
     * @return void
     */
    public function enterNode(Node $node): void {

        $this->currentLocation->setNode($node);

        foreach($this->sinks as $sinkName){

            if($sinkName::is($node)){

                $sink = new $sinkName(clone $this->currentLocation);
                $this->report->add($sink);
            }
        }
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