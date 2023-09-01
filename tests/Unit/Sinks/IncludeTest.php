<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileInclusion\IncludeSink;

it('detects "include(), include_once(), require(), require_once()" tokens (file inclusion)', function(){

    $file = new File(__DIR__ . '/../files/IncludeFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(4)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(8)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(9)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(12)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(13)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(16)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);

    expect($sinks->inFile($file)
        ->inLine(17)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(IncludeSink::class);
});