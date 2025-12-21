<?php

declare(strict_types=1);

use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\CodeExecution\PassthruSink;

it('detects "passthru()" tokens (code execution)', function () {
    $file = new File(__DIR__.'/../files/PassthruFile.php');
    $sinks = (new Analyser)->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(4)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(PassthruSink::class);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(PassthruSink::class);
});
