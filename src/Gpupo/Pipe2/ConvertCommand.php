<?php

namespace Gpupo\Pipe2;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('convert')
            ->setDescription('Convert Xml file to xmlpipe2 format')
            ->addArgument(
                'file',
                InputArgument::OPTIONAL,
                'Xml file path'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'Input Xml Format(google, blank)',
                'google'
            )
            ->addOption(
                'output',
                null,
                InputOption::VALUE_OPTIONAL,
                'Output filename',
                'stder'
            )
            ->addOption(
                'channel',
                null,
                InputOption::VALUE_OPTIONAL,
                'Channel name for fill channel item field',
                'xml'
            )
            ->addOption(
                'pretty',
                null,
                InputOption::VALUE_OPTIONAL,
                'Nicely formats output with indentation and extra space',
                false
            )
        ;
    }

    protected function getParameters(InputInterface $input)
    {
        $parameters = array(
            'input'         => $input->getArgument('file'),
            'output'        => $input->getOption('output'),
            'channel'       => $input->getOption('channel'),
            'format'        => (is_null($input->getArgument('file')) ? 'Blank' :ucfirst($input->getOption('format'))),
            'formatOutput'  => ($input->getOption('pretty') == 'true') ? true : false,
        );

        return $parameters;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = $this->getParameters($input);
        $validator = new InputValidator;

        if ($validator->validateInputParameters($parameters)) {
            $converter = '\\Gpupo\Pipe2\Converter\\' . $parameters['format'] . 'Converter';
            $convert = new $converter($parameters);
            $output->writeln($convert->execute()->getDocument()->saveXml());
        }
    }
}
