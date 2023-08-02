<?php

namespace Angelej\PhpInsider;

use PhpParser\Node;

class Location {

    /**
     * @var \Angelej\PhpInsider\File
     */
    private File $file;

    /**
     * @var \PhpParser\Node|null
     */
    private ?Node $node;

    /**
     * @param  \Angelej\PhpInsider\File $file
     */
    public function __construct(File $file){

        $this->setFile($file);
    }

    /**
     * @return string
     */
    public function getPathname(): string {

        return $this->file->getRealPath();
    }

    /**
     * @return int
     */
    public function getLine(): int {

        return $this->node->getLine();
    }

    /**
     * @return \Angelej\PhpInsider\File
     */
    public function getFile(): File {

        return $this->file;
    }

    /**
     * @param  \Angelej\PhpInsider\File $file
     * @return $this
     */
    public function setFile(File $file): self {

        $this->file = $file;
        $this->node = null;
        return $this;
    }

    /**
     * @param  \PhpParser\Node $node
     * @return $this
     */
    public function setNode(Node $node): self {

        $this->node = $node;
        return $this;
    }
}