<?php

eval('echo "static eval()";');

$code = 'echo "dynamic eval()";';
eval($code);

system('#static system()');

$cmd = '#dynamic';
system($cmd);

`#static backtick`;
`$cmd`;

exec('#static exec()');
exec($cmd);