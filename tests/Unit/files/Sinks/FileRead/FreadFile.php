<?php declare(strict_types=1);

$fp = fopen('file.txt', 'r');
$length = 1024;
fread($fp, $length);
fread($fp, 1024);