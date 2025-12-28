<?php

declare(strict_types=1);

it('executes binary', function () {
    exec('./bin/insider analyse tests/Unit/files/EvalFile.php', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(1);

    exec('./bin/insider analyze tests/Unit/files --exclude-file=tests/Unit/files/EvalFile.php', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(1);
});

it('outputs json', function () {
    exec('./bin/insider analyse tests/Unit/files/EvalFile.php --format=json', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(1);
    $output = implode("\n", $output);
    expect(json_validate($output))
        ->toBeTrue();
});