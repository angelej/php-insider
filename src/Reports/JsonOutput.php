<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Reports;

use Angelej\PhpInsider\Sinks\Sink;

class JsonOutput extends Output
{
    public function output(): void
    {
        $sinks = array_map(function (Sink $sink) {
            return [
                'name' => $sink->getSinkName(),
                'level' => $sink->getLevel()->value,
                'path' => $sink->getLocation()->getFile()->getPathname(),
                'line' => $sink->getLocation()->getLine(),
                'class' => $sink->getLocation()->getClassNode()?->name?->toString(),
                'method' => $sink->getLocation()->getMethodNode()?->name?->toString(),
                'function' => $sink->getLocation()->getFunctionNode()?->name?->toString(),
            ];
        }, $this->report->get());

        echo json_encode(
            [
                'sinks' => $sinks,
            ],
            flags: JSON_PRETTY_PRINT).PHP_EOL;
    }
}
