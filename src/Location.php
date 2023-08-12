<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use const PHP_EOL;

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
     * @var \PhpParser\Node\Stmt\Class_|null
     */
    private ?Class_ $classNode;

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
        return $this;
    }

    /**
     * @param  \PhpParser\Node $node
     * @return $this
     */
    public function setNode(Node $node): self {

        $this->node = $node;

        if($node instanceof Class_){

            $this->classNode = $node;
        }
        return $this;
    }

    /**
     * @param  \PhpParser\Node\Stmt\Class_|null $node
     * @return $this
     */
    public function setClassNode(?Class_ $node): self {

        $this->classNode = $node;
        return $this;
    }
}