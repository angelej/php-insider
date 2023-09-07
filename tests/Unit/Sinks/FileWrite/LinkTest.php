<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileWrite\LinkSink;

it('detects "link()" tokens (file write)', function(){

    $file = new File(__DIR__ . '/../../files/Sinks/FileWrite/LinkFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(LinkSink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(LinkSink::class);

    expect($sinks->inFile($file)
        ->inLine(7)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(LinkSink::class);

    expect($sinks->inFile($file)
        ->inLine(8)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(LinkSink::class);
});