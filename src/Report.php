<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use Angelej\PhpInsider\Sinks\Sink;

final class Report {

    /**
     * @var \Angelej\PhpInsider\Report|null
     */
    private static ?Report $instance = null;

    /**
     * @var \Angelej\PhpInsider\File|null
     */
    private ?File $inFile = null;

    /**
     * @var string|null
     */
    private ?string $ofSink = null;

    /**
     * @var int|null
     */
    private ?int $inLine = null;

    /** @var \Angelej\PhpInsider\Level|null */
    private ?Level $ofLevel = null;

    /**
     * @var \Angelej\PhpInsider\Sinks\Sink[]
     */
    protected array $reports = [];

    /**
     * Prevent initialization outside of singleton
     */
    private function __construct(){

    }

    /**
     * @param  \Angelej\PhpInsider\Sinks\Sink $sink
     * @return void
     */
    public function add(Sink $sink): void {

        $this->reports[] = $sink;
    }

    /**
     * @param  \Angelej\PhpInsider\File $file
     * @return $this
     */
    public function inFile(File $file): self {

        $this->inFile = $file;
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
     * @param  \Angelej\PhpInsider\Level $level
     * @return self
     */
    public function ofLevel(Level $level): self {

        $this->ofLevel = $level;
        return $this;
    }

    /**
     * @param  int $line
     * @return $this
     */
    public function inLine(int $line): self {

        $this->inLine = $line;
        return $this;
    }

    /**
     * @return \Angelej\PhpInsider\Sinks\Sink[]
     */
    public function get(): array {

        $result = [];

        foreach($this->reports as $sink){

            if($this->inFile && $sink->getLocation()->getFile() !== $this->inFile){
                continue;
            }

            if($this->ofSink && get_class($sink) !== $this->ofSink){
                continue;
            }

            if($this->inLine && $sink->getLocation()->getLine() !== $this->inLine){
                continue;
            }

            if($this->ofLevel && $sink->getLevel() !== $this->ofLevel){
                continue;
            }
            $result[] = $sink;
        }

        // reset criteria
        $this->inFile = null;
        $this->inLine = null;
        $this->ofSink = null;
        $this->ofLevel = null;

        return $result;
    }

    /**
     * @return \Angelej\PhpInsider\Sinks\Sink|null
     */
    public function first(): ?Sink {

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