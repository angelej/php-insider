<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use PhpParser\Node\Stmt\ClassMethod;

it('locates "method" tokens', function(){

    $file = new File(__DIR__ . '/../files/Locations/ClassFile.php');
    $sinks = (new Analyser())->analyse($file);
    $methodNode = $sinks->inFile($file)
        ->inLine(7)
        ->first()
        ?->getLocation()
        ?->getMethodNode();

    expect($methodNode)
        ->toBeInstanceOf(ClassMethod::class)
        ->and((string) $methodNode?->name)
        ->toBe('exec');
});