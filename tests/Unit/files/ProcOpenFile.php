<?php declare(strict_types=1);

$cmd = '# proc_open()';
proc_open($cmd, [STDIN, STDOUT, STDOUT], $pipes);
proc_open('# proc_open()', [STDIN, STDOUT, STDOUT], $pipes);