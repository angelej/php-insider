<?php declare(strict_types=1);

$fp = fopen('file.txt', 'w');
$data = 'Payload';
fwrite($fp, $data);
fwrite($fp, 'Payload');