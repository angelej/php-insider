<?php

it('executes binary', function(){

    exec('./bin/insider analyse tests/files/CodeExecution.php', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(0);

    exec('./bin/insider analyse tests/files --exclude-file=tests/files/CodeExecution.php', $output, $resultCode);
    expect($resultCode)
        ->toBeInt()
        ->toBe(0);
});