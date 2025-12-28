<?php

declare(strict_types=1);

use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\FileRead\FreadSink;

it('detects "fread()" tokens (file read)', function () {
    $file = new File(__DIR__.'/../../files/Sinks/FileRead/FreadFile.php');
    $sinks = (new Analyser)->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::max())
        ->first()
    )->toBeInstanceOf(FreadSink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->ofLevel(Level::max())
        ->first()
    )->toBeInstanceOf(FreadSink::class);
});
