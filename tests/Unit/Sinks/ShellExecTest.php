<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\CodeExecution\ShellExecSink;

it('detects "shell_exec()" tokens (code execution)', function(){

    $file = new File(__DIR__ . '/../files/ShellExecFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(4)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(ShellExecSink::class);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(ShellExecSink::class);
});