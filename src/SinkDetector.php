<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Angelej\PhpInsider\Sinks\FileRead\FileSink;
use Angelej\PhpInsider\Sinks\FileWrite\CopySink;
use Angelej\PhpInsider\Sinks\FileRead\ReadfileSink;
use Angelej\PhpInsider\Sinks\CodeExecution\EvalSink;
use Angelej\PhpInsider\Sinks\CodeExecution\ExecSink;
use Angelej\PhpInsider\Sinks\CodeExecution\SystemSink;
use Angelej\PhpInsider\Sinks\FileInclusion\IncludeSink;
use Angelej\PhpInsider\Sinks\CodeExecution\BacktickSink;
use Angelej\PhpInsider\Sinks\CodeExecution\PassthruSink;
use Angelej\PhpInsider\Sinks\CodeExecution\ShellExecSink;
use Angelej\PhpInsider\Sinks\FileRead\FileGetContentsSink;
use Angelej\PhpInsider\Sinks\FileWrite\FilePutContentsSink;

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
        ShellExecSink::class,
        FileGetContentsSink::class,
        FileSink::class,
        ReadfileSink::class,
        FilePutContentsSink::class,
        CopySink::class
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
     * @param  \PhpParser\Node $node
     * @return void
     */
    public function leaveNode(Node $node): void {

        // leave class
        if($this->currentLocation->getClassNode() === $node){

            $this->currentLocation->setClassNode(null);
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