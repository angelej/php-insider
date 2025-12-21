<?php

declare(strict_types=1);

use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Sinks\InformationDisclosure\PhpinfoSink;

it('detects "phpinfo()" tokens (information disclosure)', function () {
    $file = new File(__DIR__.'/../../files/Sinks/InformationDisclosure/PhpinfoFile.php');
    $sinks = (new Analyser)->analyse($file);

    expect($sinks->inFile($file)
        ->inLine(3)
        ->ofLevel(Level::max())
        ->first()
    )->toBeInstanceOf(PhpinfoSink::class);
});
