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
            ->setName('convert')
            ->setDescription('Convert Xml file in Google Shopping format to XmlPipe 2 format')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Xml file path'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'Input Xml Format',
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = array(
            'input'         => $input->getArgument('file'),
            'output'        => $input->getOption('output'),
            'channel'       => $input->getOption('channel'),
            'formatOutput'  => ($input->getOption('pretty') == 'true') ? true : false,
        );

        $validator = new InputValidator;

        $converter = '\\Gpupo\Pipe2\Converter\\' . ucfirst($input->getOption('format')) . 'Converter';
        if ($validator->validateInputParameters($parameters)) {
            $convert = new $converter($parameters);
            $output->writeln($convert->execute()->getDocument()->saveXml());
        }
    }
}
