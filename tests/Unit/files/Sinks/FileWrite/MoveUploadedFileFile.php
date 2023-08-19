<?php declare(strict_types=1);

$source = 'source.txt';
$target = 'target.txt';
move_uploaded_file($source, $target);
move_uploaded_file($source, 'target.txt');
move_uploaded_file('source.txt', $target);
move_uploaded_file('source.txt', 'target.txt');