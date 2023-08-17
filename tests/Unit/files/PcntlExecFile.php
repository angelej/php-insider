<?php declare(strict_types=1);

$cmd = '# pcntl_exec()';
$args = ['foo' => 'bar'];
pcntl_exec($cmd, $args);
pcntl_exec('# pcntl_exec()');