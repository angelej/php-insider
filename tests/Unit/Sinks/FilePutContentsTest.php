<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileWrite\FilePutContentsSink;

it('detects "file_put_contents()" tokens (file write)', function(){

    $file = new File(__DIR__ . '/../files/FilePutContentsFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->first()
    )->toBeInstanceOf(FilePutContentsSink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->first()
    )->toBeInstanceOf(FilePutContentsSink::class);

    expect($sinks->inFile($file)
        ->inLine(7)
        ->first()
    )->toBeInstanceOf(FilePutContentsSink::class);

    expect($sinks->inFile($file)
        ->inLine(8)
        ->first()
    )->toBeNull();
});