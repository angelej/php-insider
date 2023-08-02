<?php declare(strict_types=1);

it('executes binary', function(){

    exec('./bin/insider analyse tests/Unit/files/EvalFile.php', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(0);

    exec('./bin/insider analyse tests/Unit/files --exclude-file=tests/Unit/files/EvalFile.php', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(0);
});