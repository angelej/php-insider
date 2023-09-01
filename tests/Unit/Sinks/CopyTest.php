<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileWrite\CopySink;

it('detects "copy()" tokens (file write)', function(){

    $file = new File(__DIR__ . '/../files/CopyFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(CopySink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(CopySink::class);

    expect($sinks->inFile($file)
        ->inLine(7)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(CopySink::class);

    expect($sinks->inFile($file)
        ->inLine(8)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(CopySink::class);
});