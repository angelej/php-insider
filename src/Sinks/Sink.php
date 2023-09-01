<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Sinks;

use ReflectionClass;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Location;

abstract class Sink implements SinkInterface {

    /**
     * @var \Angelej\PhpInsider\Location
     */
    protected Location $location;

    /** @var \Angelej\PhpInsider\Level */
    protected Level $level;

    /**
     * @param  \Angelej\PhpInsider\Location $location
     * @param  \Angelej\PhpInsider\Level $level
     */
    public function __construct(Location $location, Level $level){

        $this->location = $location;
        $this->level = $level;
    }

    /**
     * @return \Angelej\PhpInsider\Location
     */
    public function getLocation(): Location {

        return $this->location;
    }

    /** @return \Angelej\PhpInsider\Level */
    public function getLevel(): Level {

        return $this->level;
    }

    /**
     * @return string
     */
    public function getSinkName(): string {

        return (new ReflectionClass($this))->getShortName();
    }
}