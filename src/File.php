<?php

namespace Angelej\PhpInsider;

use SplFileObject;

/**
 * @mixin \SplFileObject
 */
class File {

    /**
     * @var \SplFileObject
     */
    protected SplFileObject $file;

    /**
     * @param  string $path
     */
    public function __construct(string $path){

        $this->file = new SplFileObject($path);
    }

    /**
     * @return string
     */
    public function getContent(): string {

        return $this->fread($this->getSize());
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed {

        return $this->file->$name(...$arguments);
    }
}