<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\ClassMethod;
use const PHP_EOL;

class Location {

    /**
     * @var \Angelej\PhpInsider\File
     */
    private File $file;

    /**
     * @var \PhpParser\Node|null
     */
    private ?Node $node = null;

    /**
     * @var \PhpParser\Node\Stmt\Class_|null
     */
    private ?Class_ $classNode = null;

    /**
     * @var \PhpParser\Node\Stmt\ClassMethod|null
     */
    private ?ClassMethod $methodNode = null;

    /**
     * @var \PhpParser\Node\Stmt\Function_|null
     */
    private ?Function_ $functionNode = null;

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

        return $this->file->getPathname();
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
     * @return \PhpParser\Node\Stmt\Class_|null
     */
    public function getClassNode(): ?Class_ {

        return $this->classNode;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function getMethodNode(): ?ClassMethod {

        return $this->methodNode;
    }

    /**
     * @return \PhpParser\Node\Stmt\Function_|null
     */
    public function getFunctionNode(): ?Function_ {

        return $this->functionNode;
    }

    /**
     * @param  int $expand
     * @return string
     */
    public function getCodeSnippet(int $expand = 0): string {

        $snippet = '';
        $fp = @fopen('file://' . $this->file->getRealPath(), 'r');

        if($fp){

            $start = max($this->node->getStartLine() - $expand, 1);
            $end = $this->node->getEndLine() + $expand;
            $line = 1;

            while(!feof($fp)){

                if($line > $end) break;

                $buffer = fgets($fp);

                if($line >= $start){

                    /**
                     * workaround for termwind's extra space elimination
                     */
                    if(!trim($snippet) && !trim($buffer)){
                        $buffer = '// empty line' . PHP_EOL;
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
     * @param  \Angelej\PhpInsider\File $file
     * @return $this
     */
    public function setFile(File $file): self {

        $this->file = $file;
        $this->node = null;
        $this->classNode = null;
        $this->methodNode = null;
        $this->functionNode = null;
        return $this;
    }

    /**
     * @param  \PhpParser\Node $node
     * @return $this
     */
    public function setNode(Node $node): self {

        $this->node = $node;

        switch(true){
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
     * @param  \PhpParser\Node\Stmt\Class_|null $node
     * @return $this
     */
    public function setClassNode(?Class_ $node): self {

        $this->classNode = $node;
        $this->methodNode = null;
        $this->functionNode = null;
        return $this;
    }

    /**
     * @param  \PhpParser\Node\Stmt\ClassMethod|null $node
     * @return $this
     */
    public function setMethodNode(?ClassMethod $node): self {

        $this->methodNode = $node;
        return $this;
    }

    /**
     * @param  \PhpParser\Node\Stmt\Function_|null $node
     * @return $this
     */
    public function setFunctionNode(?Function_ $node): self {

        $this->functionNode = $node;
        return $this;
    }
}