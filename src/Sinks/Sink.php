<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks;

use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Location;
use ReflectionClass;

abstract class Sink implements SinkInterface
{
    protected Location $location;

    protected Level $level;

    public function __construct(Location $location, Level $level)
    {
        $this->location = $location;
        $this->level = $level;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function getSinkName(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}
