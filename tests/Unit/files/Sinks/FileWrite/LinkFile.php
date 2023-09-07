<?php declare(strict_types=1);

$link = 'link';
$target = 'target.txt';
link($target, $link);
link($target, 'link');
link('target.txt', $link);
link('target.txt', 'link');