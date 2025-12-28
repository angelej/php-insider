<?php

declare(strict_types=1);

use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\FileWrite\FwriteSink;

it('detects "fwrite()" tokens (file write)', function () {
    $file = new File(__DIR__.'/../../files/Sinks/FileWrite/FwriteFile.php');
    $sinks = (new Analyser)->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(FwriteSink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(FwriteSink::class);
});
