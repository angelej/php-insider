<?php

namespace Angelej\PhpInsider;

use PhpParser\Node;
use ReflectionClass;
use Angelej\PhpInsider\Sinks\Sink;
use const PHP_EOL;

class Report {

    /**
     * @var \Angelej\PhpInsider\Report|null
     */
    private static ?Report $instance = null;

    /**
     * @var \Angelej\PhpInsider\File|null
     */
    private ?File $ofFile = null;

    /**
     * @var string|null
     */
    private ?string $ofSink = null;

    /**
     * @var int|null
     */
    private ?int $ofLine = null;

    /**
     * @var array
     */
    protected array $reports = [];

    /**
     * Prevent initialization outside of singleton
     */
    private function __construct(){

    }

    /**
     * @param  \Angelej\PhpInsider\File $file
     * @param  \Angelej\PhpInsider\Sinks\Sink $sink
     * @param  \PhpParser\Node $node
     * @return void
     */
    public function add(File $file, Sink $sink, Node $node): void {

        $this->reports[] = [
            'file' => $file,
            'node' => $node,
            'sink' => $sink
        ];

        $filename = $file->getRealPath();
        $line = $node->getLine();
        $sinkType = (new ReflectionClass($sink))->getShortName();

        echo "Found {$sinkType} sink in file \"{$filename}:{$line}\"" . PHP_EOL;
    }

    /**
     * @param  \Angelej\PhpInsider\File $file
     * @return $this
     */
    public function ofFile(File $file): self {

        $this->ofFile = $file;
        return $this;
    }

    /**
     * @param  string $sink
     * @return $this
     */
    public function ofSink(string $sink): self {

        $this->ofSink = $sink;
        return $this;
    }

    /**
     * @param  int $line
     * @return $this
     */
    public function ofLine(int $line): self {

        $this->ofLine = $line;
        return $this;
    }

    /**
     * @return array
     */
    public function get(): array {

        $result = [];

        foreach($this->reports as $report){

            if($this->ofFile && $report['file'] !== $this->ofFile){
                continue;
            }

            if($this->ofSink && get_class($report['sink']) !== $this->ofSink){
                continue;
            }

            if($this->ofLine && $report['node']->getLine() !== $this->ofLine){
                continue;
            }
            $result[] = $report;
        }

        // reset criteria
        $this->ofFile = null;
        $this->ofLine = null;
        $this->ofSink = null;

        return $result;
    }

    /**
     * @return array|null
     */
    public function first(): ?array {

        return $this->get()[0] ?? null;
    }

    /**
     * @return static
     */
    public static function getInstance(): static {

        if(static::$instance === null){

            static::$instance = new static();
        }
        return static::$instance;
    }
}