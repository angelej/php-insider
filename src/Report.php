<?php

declare(strict_types=1);

namespace Angelej\PhpInsider;

use Angelej\PhpInsider\Sinks\Sink;

final class Report
{
    private static ?Report $instance = null;

    private ?File $inFile = null;

    private ?string $ofSink = null;

    private ?int $inLine = null;

    private ?Level $ofLevel = null;

    /**
     * @var \Angelej\PhpInsider\Sinks\Sink[]
     */
    protected array $reports = [];

    /**
     * Prevent initialization outside of singleton
     */
    private function __construct() {}

    public function add(Sink $sink): void
    {
        $this->reports[] = $sink;
    }

    /**
     * @return $this
     */
    public function inFile(File $file): self
    {
        $this->inFile = $file;

        return $this;
    }

    /**
     * @return $this
     */
    public function ofSink(string $sink): self
    {
        $this->ofSink = $sink;

        return $this;
    }

    public function ofLevel(Level $level): self
    {
        $this->ofLevel = $level;

        return $this;
    }

    /**
     * @return $this
     */
    public function inLine(int $line): self
    {
        $this->inLine = $line;

        return $this;
    }

    /**
     * @return \Angelej\PhpInsider\Sinks\Sink[]
     */
    public function get(): array
    {
        $result = [];

        foreach ($this->reports as $sink) {
            if ($this->inFile && $sink->getLocation()->getFile() !== $this->inFile) {
                continue;
            }

            if ($this->ofSink && get_class($sink) !== $this->ofSink) {
                continue;
            }

            if ($this->inLine && $sink->getLocation()->getLine() !== $this->inLine) {
                continue;
            }

            if ($this->ofLevel && $sink->getLevel() !== $this->ofLevel) {
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

    public function first(): ?Sink
    {
        return $this->get()[0] ?? null;
    }

    public static function getInstance(): static
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
