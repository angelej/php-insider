<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Reports;

use Angelej\PhpInsider\LocationHelper;

use function Termwind\render;

class TextOutput extends Output
{
    public function output(): void
    {
        foreach ($sinks = $this->report->get() as $sink) {
            $location = $sink->getLocation();
            $line = $location->getLine();
            $startLine = max($line - $this->expandLines, 1);
            $codeSnippet = $location->getCodeSnippet($this->expandLines);

            if (! str_starts_with($codeSnippet, '<?')) {
                $startLine = max($startLine - 1, 1);
                $codeSnippet = '<?php'.PHP_EOL.$codeSnippet;
            }

            $codeSnippet = htmlentities($codeSnippet);
            $breadcrumb = LocationHelper::printBreadcrumb($location);

            render(<<<INSIDER_SINK
                    <div class="ml-2 mb-1">
                        <span class="px-1 font-bold bg-red-600 text-black">{$sink->getSinkName()}</span> found in file {$breadcrumb}
                        <code line="{$line}" start-line="{$startLine}">{$codeSnippet}</code>
                    </div>
                INSIDER_SINK
            );
        }

        $totalSinks = count($sinks);
        $noun = $totalSinks === 1 ? 'sink' : 'sinks';

        render(<<<INSIDER_SUMMARY
            <div class="ml-2 mt-1 font-bold">
                <span class="bg-white text-black px-1">Summary:</span> {$totalSinks} {$noun} found
            </div>
        INSIDER_SUMMARY);
    }
}
