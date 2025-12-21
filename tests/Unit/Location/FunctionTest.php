<?php

declare(strict_types=1);

use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\File;
use PhpParser\Node\Stmt\Function_;

it('locates "function" tokens', function () {
    $file = new File(__DIR__.'/../files/Locations/FunctionFile.php');
    $sinks = (new Analyser)->analyse($file);
    $functionNode = $sinks->inFile($file)
        ->inLine(5)
        ->first()
        ?->getLocation()
        ?->getFunctionNode();

    expect($functionNode)
        ->toBeInstanceOf(Function_::class)
        ->and((string) $functionNode?->name)
        ->toBe('execFunc');
});
