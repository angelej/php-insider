<?php declare(strict_types=1);

$includeFile = 'include.php';
include $includeFile;
include 'include.php';

$includeOnceFile = 'include_once.php';
include_once $includeOnceFile;
include_once 'include_once.php';

$requireFile = 'require.php';
require $requireFile;
require 'require.php';

$requireOnceFile = 'require_once.php';
require_once $requireOnceFile;
require_once 'require_once.php';