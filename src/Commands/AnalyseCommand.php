<?php declare(strict_types=1);

namespace Angelej\PhpInsider\Commands;

use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\Sinks\Sink;
use Angelej\PhpInsider\LocationHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Termwind\render;

#[AsCommand(
    name: 'analyse',
    description: 'Analyses source code',
    aliases: ['analyze']
)]
class AnalyseCommand extends Command {

    /**
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {

        $file = $input->getArgument('file');
        $extensions = $this->getExtensionsOption($input);
        $excludedFiles = $input->getOption('exclude-file');
        $files = is_dir($file) ? File::glob($file, $extensions, $excludedFiles) : new File($file);
        $expandLines = max((int) $input->getOption('lines'), 0);

        $report = (new Analyser())->analyse($files);
        $sinks = $report->get();

        foreach($sinks as $sink){

            $this->printSink($sink, $expandLines);
        }
        $this->printSummary($sinks);

        return count($sinks) > 0
            ? Command::FAILURE
            : Command::SUCCESS;
    }

    /**
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @return string[]
     */
    private function getExtensionsOption(InputInterface $input): array {

        return array_map(function($ext){
            return ltrim(trim($ext), '.');
        }, $input->getOption('extension'));
    }

    /**
     * @param  \Angelej\PhpInsider\Sinks\Sink $sink
     * @param  int $expandLines
     * @return void
     */
    private function printSink(Sink $sink, int $expandLines): void {

            $location = $sink->getLocation();
            $line = $location->getLine();
            $startLine = max($line - $expandLines, 1);
            $codeSnippet = $location->getCodeSnippet($expandLines);
            $breadcrumb = LocationHelper::printBreadcrumb($location);

            render(<<<INSIDER_SINK
                <div class="ml-2 mb-1">
                    <span class="px-1 font-bold bg-red-600 text-black">{$sink->getSinkName()}</span> found in file {$breadcrumb}
                    <code line="{$line}" start-line="{$startLine}">{$codeSnippet}</code>
                </div>
            INSIDER_SINK);
    }

    /**
     * @param  \Angelej\PhpInsider\Sinks\Sink[] $sinks
     * @return void
     */
    private function printSummary(array $sinks): void {

        $totalSinks = count($sinks);
        $noun = $totalSinks === 1 ? 'sink' : 'sinks';

        render(<<<INSIDER_SUMMARY
            <div class="ml-2 mt-1 font-bold">
                <span class="bg-white text-black px-1">Summary:</span> {$totalSinks} {$noun} found
            </div>
        INSIDER_SUMMARY);
    }

    /** @return void */
    protected function configure(): void {

        $this
            ->addArgument('file', InputArgument::REQUIRED, 'File or directory path to analyse')
            ->addOption('extension', '-e', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'File extension', ['php'])
            ->addOption('exclude-file', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'File or directory to exclude', [])
            ->addOption('lines', '-l', InputOption::VALUE_REQUIRED, 'Number of lines to expand code snippet', 2);
    }
}