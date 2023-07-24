<?php

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\CodeExecution;

it('detects code execution sinks', function(){

    $file = new File(__DIR__ . '/../../files/CodeExecution.php');
    $report = (new Analyser())->setSinks([
        CodeExecution::class
    ])->analyse($file);

    // static eval()
    expect($report->ofFile($file)
        ->ofLine(3)
        ->first()
    )->toBeNull();

    // dynamic eval()
    expect($report->ofFile($file)
        ->ofLine(6)
        ->first()
    )->not()->toBeNull();

    // static system()
    expect($report->ofFile($file)
        ->ofLine(8)
        ->first()
    )->toBeNull();

    // dynamic system()
    expect($report->ofFile($file)
        ->ofLine(11)
        ->first()
    )->not()->toBeNull();

    // static backticks
    expect($report->ofFile($file)
        ->ofLine(13)
        ->first()
    )->toBeNull();

    // dynamic backticks
    expect($report->ofFile($file)
        ->ofLine(14)
        ->first()
    )->not()->toBeNull();
});
