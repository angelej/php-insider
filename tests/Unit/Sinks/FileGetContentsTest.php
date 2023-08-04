<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileRead\FileGetContentsSink;

it('detects "file_get_contents()" tokens (file read)', function(){

    $file = new File(__DIR__ . '/../files/FileGetContentsFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(4)
        ->first()
    )->toBeInstanceOf(FileGetContentsSink::class);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->first()
    )->toBeNull();
});