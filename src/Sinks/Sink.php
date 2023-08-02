<?php

namespace Angelej\PhpInsider\Sinks;

use Angelej\PhpInsider\Location;

abstract class Sink implements SinkInterface {

    /**
     * @var \Angelej\PhpInsider\Location
     */
    protected Location $location;

    /**
     * @param  \Angelej\PhpInsider\Location $location
     */
    public function __construct(Location $location){

        $this->location = $location;
    }

    /**
     * @return \Angelej\PhpInsider\Location
     */
    public function getLocation(): Location {

        return $this->location;
    }
}