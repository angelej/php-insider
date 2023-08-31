<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\CodeExecution\PcntlExecSink;

it('detects "pcntl_exec()" tokens (code execution)', function(){

    $file = new File(__DIR__ . '/../files/PcntlExecFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(5)
        ->ofLevel(Level::ONE)
        ->first()
    )->toBeInstanceOf(PcntlExecSink::class);

    expect($sinks->inFile($file)
        ->inLine(6)
        ->ofLevel(Level::ZERO)
        ->first()
    )->toBeInstanceOf(PcntlExecSink::class);
});