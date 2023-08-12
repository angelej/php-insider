<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use PhpParser\Node\Stmt\Class_;
use Angelej\PhpInsider\Analyser;

it('locates "class" tokens', function(){

    $file = new File(__DIR__ . '/../files/Locations/ClassTest.php');
    $sinks = (new Analyser())->analyse($file);
    $classNode = $sinks->inFile($file)
        ->inLine(7)
        ->first()
        ?->getLocation()
        ?->getClassNode();

    expect($classNode)
        ->toBeInstanceOf(Class_::class)
        ->and((string) $classNode?->name)
        ->toBe('ClassTest');
});