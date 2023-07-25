<?php

namespace Angelej\PhpInsider;

use Exception;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;
use Angelej\PhpInsider\Sinks\FileInclusion;
use Angelej\PhpInsider\Sinks\CodeExecution;

class Analyser {

    /**
     * @var \PhpParser\Parser
     */
    protected Parser $parser;

    /**
     * @var array|string[]
     */
    protected array $sinks = [
        FileInclusion::class,
        CodeExecution::class
    ];

    public function __construct(){

        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    /**
     * @param  array|\Angelej\PhpInsider\File[]|\Angelej\PhpInsider\File $files
     * @return \Angelej\PhpInsider\Report
     */
    public function analyse(array|File $files): Report {

        if(!is_array($files)) $files = [$files];

        foreach($files as $file){

            $traverser = new NodeTraverser();

            foreach($this->sinks as $sink){
                $traverser->addVisitor(new $sink($file));
            }

            try {

                $content = $file->getContent();
                $ast = $this->parser->parse($content);

                $traverser->traverse($ast);

            } catch(Exception $e){}
        }
        return Report::getInstance();
    }

    /**
     * @param  array|string[] $sinks
     * @return self
     */
    public function setSinks(array $sinks): self {

        $this->sinks = $sinks;
        return $this;
    }
}