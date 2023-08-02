<?php

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

    public function __construct(){

        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    /**
     * @param  array|\Angelej\PhpInsider\File[]|\Angelej\PhpInsider\File $files
     * @return \Angelej\PhpInsider\Report
     */
    public function analyse(array|File $files): Report {

        if(!is_array($files)) $files = [$files];

        $traverser = new NodeTraverser();
        $sinkDetector = new SinkDetector();
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
}