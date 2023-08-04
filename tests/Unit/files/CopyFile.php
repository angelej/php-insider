<?php declare(strict_types=1);

$source = 'source.txt';
$target = 'target.txt';
copy($source, $target);
copy($source, 'target.txt');
copy('source.txt', $target);
copy('source.txt', 'target.txt');