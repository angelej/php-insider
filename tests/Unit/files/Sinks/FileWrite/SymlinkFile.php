<?php declare(strict_types=1);

$link = 'link';
$target = 'target.txt';
symlink($target, $link);
symlink($target, 'link');
symlink('target.txt', $link);
symlink('target.txt', 'link');