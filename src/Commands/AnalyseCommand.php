<?php

declare(strict_types=1);

namespace Angelej\PhpInsider\Commands;

use Angelej\PhpInsider\Analyser;
use Angelej\PhpInsider\File;
use Angelej\PhpInsider\Level;
use Angelej\PhpInsider\Reports\JsonOutput;
use Angelej\PhpInsider\Reports\TextOutput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'analyse',
    description: 'Analyses source code',
    aliases: ['analyze']
)]
class AnalyseCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($memoryLimit = $input->getOption('memory-limit')) {
            if (ini_set('memory_limit', $memoryLimit) === false) {
                throw new InvalidOptionException('Invalid "--memory-limit" value provided.');
            }
        }

        $file = $input->getArgument('file');
        $extensions = $this->getExtensionsOption($input);
        $excludedFiles = $input->getOption('exclude-file');
        $files = is_dir($file) ? File::glob($file, $extensions, $excludedFiles) : new File($file);
        $expandLines = max((int) $input->getOption('lines'), 0);
        $level = $this->getLevelOption($input);
        $outputFormat = $this->getOutputFormatOption($input);

        $report = (new Analyser)
            ->setLevel($level)
            ->analyse($files);

        if ($outputFormat === 'json') {
            new JsonOutput($report, $expandLines)->output();
        } else {
            new TextOutput($report, $expandLines)->output();
        }

        return count($report->get()) > 0
            ? Command::FAILURE
            : Command::SUCCESS;
    }

    private function getLevelOption(InputInterface $input): int
    {
        $level = (int) $input->getOption('level');
        $min = Level::min()->value;
        $max = Level::max()->value;

        if ($level < $min || $level > $max) {
            throw new InvalidOptionException('Invalid "--level" value provided. Level must be between '.$min.' and '.$max.'.');
        }

        return $level;
    }

    /**
     * @return string[]
     */
    private function getExtensionsOption(InputInterface $input): array
    {
        return array_map(function ($ext) {
            return ltrim(trim($ext), '.');
        }, $input->getOption('extension'));
    }

    private function getOutputFormatOption(InputInterface $input): string
    {
        $format = strtolower(trim((string) $input->getOption('format')));
        $validFormats = ['text', 'json'];

        if (! in_array($format, $validFormats, true)) {
            throw new InvalidOptionException('Invalid "--format" value provided. Valid formats are: '.implode(', ', $validFormats).'.');
        }

        return $format;
    }

    protected function configure(): void
    {
        $minLevel = Level::min()->value;
        $maxLevel = Level::max()->value;

        $this
            ->addArgument('file', InputArgument::REQUIRED, 'File or directory path to analyse')
            ->addOption('level', '-l', InputOption::VALUE_REQUIRED, 'Level of analysis ['.$minLevel.'-'.$maxLevel.']. The higher the level, the more selective the analysis', 0)
            ->addOption('extension', '-e', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'File extension', ['php'])
            ->addOption('exclude-file', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'File or directory to exclude', [])
            ->addOption('lines', null, InputOption::VALUE_REQUIRED, 'Number of lines to expand code snippet', 2)
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output format (text, json)', 'text')
            ->addOption('memory-limit', null, InputOption::VALUE_REQUIRED, 'Memory limit');
    }
}
