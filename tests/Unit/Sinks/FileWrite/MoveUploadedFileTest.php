<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileWrite\MoveUploadedFileSink;

it('detects "move_uploaded_file()" tokens (file write)', function(){

    $file = new File(__DIR__ . '/../../files/Sinks/FileWrite/MoveUploadedFileFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->first()
    )->toBeInstanceOf(MoveUploadedFileSink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->first()
    )->toBeInstanceOf(MoveUploadedFileSink::class);

    expect($sinks->inFile($file)
        ->inLine(7)
        ->first()
    )->toBeInstanceOf(MoveUploadedFileSink::class);

    expect($sinks->inFile($file)
        ->inLine(8)
        ->first()
    )->toBeNull();
});