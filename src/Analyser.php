<?php declare(strict_types=1);

namespace Angelej\PhpInsider;

use Exception;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;

class Analyser {

    /**
     * @var \PhpParser\Parser
     */
    protected Parser $parser;

    /** @var int */
    protected int $level = 0;

    public function __construct(){

        $this->parser = (new ParserFactory())->createForNewestSupportedVersion();
    }

    /**
     * @param  array|\Angelej\PhpInsider\File[]|\Angelej\PhpInsider\File $files
     * @return \Angelej\PhpInsider\Report
     */
    public function analyse(array|File $files): Report {

        if(!is_array($files)) $files = [$files];

        $traverser = new NodeTraverser();
        $sinkDetector = (new SinkDetector())->setLevel($this->level);
        $traverser->addVisitor($sinkDetector);

        foreach($files as $file){

            try {

                $sinkDetector->setLocation(new Location($file));
                $ast = $this->parser->parse($file->getContent());
                $traverser->traverse($ast);

            } catch(Exception $e){}
        }
        return Report::getInstance();
    }

    /**
     * @param  int $level
     * @return $this
     */
    public function setLevel(int $level): self {

        $this->level = $level;
        return $this;
    }
}
