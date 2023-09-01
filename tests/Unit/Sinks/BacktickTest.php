<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\CodeExecution\BacktickSink;

it('detects "backtick" tokens (code execution)', function(){

    $file = new File(__DIR__ . '/../files/BacktickFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(4)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(BacktickSink::class);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(BacktickSink::class);
});