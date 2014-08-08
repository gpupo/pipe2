<?php

namespace Gpupo\Pipe2;

use Symfony\Component\Console\Command\Command as CommandAbstract;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends CommandAbstract
{
    protected function configure()
    {
        $this
            ->setName('convert:google')
            ->setDescription('Convert Xml file in Google Shopping format to XmlPipe 2 format')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Google Xml file path'
            )
            ->addOption(
                'output',
                null,
                InputOption::VALUE_OPTIONAL,
                'output filename',
                'stder'
            )
            ->addOption(
                'channel',
                null,
                InputOption::VALUE_OPTIONAL,
                'channel name for fill channel item field',
                'xml'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'format output',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFile = $input->getArgument('file');
        $outputFile = $input->getOption('output');
        $channel = $input->getOption('channel');
        $formatOutput = ($input->getOption('format') == 'true') ? true : false;
        $convert = new Converter\GoogleConverter($inputFile, $outputFile, $channel, $formatOutput);

        $output->writeln($convert->execute()->getDocument()->saveXml());
    }
}
