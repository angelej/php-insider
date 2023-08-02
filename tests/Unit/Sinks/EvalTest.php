<?php

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\CodeExecution\EvalSink;

it('detects "eval()" tokens (code execution)', function(){

    $file = new File(__DIR__ . '/../files/EvalFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(4)
        ->first()
    )->toBeInstanceOf(EvalSink::class);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->first()
    )->toBeNull();
});