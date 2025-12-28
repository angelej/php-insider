<?php declare(strict_types=1);

$from = 'source.txt';
$to = 'target.txt';
rename($from, $to);
rename($from, 'target.txt');
rename('source.txt', $to);
rename('source.txt', 'target.txt');