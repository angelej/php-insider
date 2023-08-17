<?php declare(strict_types=1);

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\InformationDisclosure\PhpinfoSink;

it('detects "phpinfo()" tokens (information disclosure)', function(){

    $file = new File(__DIR__ . '/../../files/Sinks/InformationDisclosure/PhpinfoFile.php');
    $sinks = (new Analyser())->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(3)
        ->first()
    )->toBeInstanceOf(PhpinfoSink::class);
});