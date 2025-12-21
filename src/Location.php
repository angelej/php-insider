<?php

declare(strict_types=1);

namespace Angelej\PhpInsider;

use const PHP_EOL;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;

class Location
{
    private File $file;

    private ?Node $node = null;

    private ?Class_ $classNode = null;

    private ?ClassMethod $methodNode = null;

    private ?Function_ $functionNode = null;

    public function __construct(File $file)
    {
        $this->setFile($file);
    }

    public function getPathname(): string
    {
        return $this->file->getPathname();
    }

    public function getLine(): int
    {
        return $this->node->getStartLine();
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getClassNode(): ?Class_
    {
        return $this->classNode;
    }

    public function getMethodNode(): ?ClassMethod
    {
        return $this->methodNode;
    }

    public function getFunctionNode(): ?Function_
    {
        return $this->functionNode;
    }

    public function getCodeSnippet(int $expand = 0): string
    {
        $expand = max($expand, 0);
        $snippet = '';
        $fp = @fopen('file://'.$this->file->getRealPath(), 'r');

        if ($fp) {
            $start = max($this->node->getStartLine() - $expand, 1);
            $end = $this->node->getEndLine() + $expand;
            $line = 1;

            while (! feof($fp)) {
                if ($line > $end) {
                    break;
                }

                $buffer = (string) fgets($fp);

                if ($line >= $start) {
                    /**
                     * workaround for termwind's extra space elimination
                     */
                    if (! trim($snippet) && ! trim($buffer)) {
                        $buffer = '// empty line'.PHP_EOL;
                    }
                    $snippet .= $buffer;
                }
                $line++;
            }
            fclose($fp);
        }

        return $snippet;
    }

    /**
     * @return $this
     */
    public function setFile(File $file): self
    {
        $this->file = $file;
        $this->node = null;
        $this->classNode = null;
        $this->methodNode = null;
        $this->functionNode = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function setNode(Node $node): self
    {
        $this->node = $node;

        switch (true) {
            case $node instanceof Class_:
                $this->setClassNode($node);
                break;

            case $node instanceof ClassMethod:
                $this->setMethodNode($node);
                break;

            case $node instanceof Function_:
                $this->setFunctionNode($node);
                break;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setClassNode(?Class_ $node): self
    {
        $this->classNode = $node;
        $this->methodNode = null;
        $this->functionNode = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethodNode(?ClassMethod $node): self
    {
        $this->methodNode = $node;

        return $this;
    }

    /**
     * @return $this
     */
    public function setFunctionNode(?Function_ $node): self
    {
        $this->functionNode = $node;

        return $this;
    }
}
