<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Reports;

abstract class Output implements OutputInterface
{
    protected Report $report;

    protected int $expandLines;

    public function __construct(Report $report, int $expandLines = 2)
    {
        $this->report = $report;
        $this->expandLines = $expandLines;
    }
}
