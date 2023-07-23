<?php

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\FileInclusion;

it('detects file inclusion sinks', function(){

    $file = new File(__DIR__ . '/../../files/FileInclusion.php');
    $report = (new Analyser())->setSinks([
        FileInclusion::class
    ])->analyse($file);

    expect($report->ofFile($file)
        ->ofLine(3)
        ->first()
    )->toBeNull();

    expect($report->ofFile($file)
        ->ofLine(6)
        ->first()
    )->not()->toBeNull();
});
