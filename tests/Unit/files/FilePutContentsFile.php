<?php declare(strict_types=1);

$path = 'file_put_contents.txt';
$content = 'file_put_contents()';
file_put_contents($path, $content);
file_put_contents($path, 'file_put_contents()');
file_put_contents('file_put_contents.txt', $content);
file_put_contents('file_put_contents.txt', 'file_put_contents()');