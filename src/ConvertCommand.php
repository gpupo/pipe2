<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            ->addOption(
            'slug',
            null,
            InputOption::VALUE_OPTIONAL,
            'add sluggables fields - schema based ',
            false
            )
            ->addOption(
                'idField',
                null,
                InputOption::VALUE_OPTIONAL,
                'Item field to fill document id',
                'sku'
            )
            ->addOption(
                'idPrefix',
                null,
                InputOption::VALUE_OPTIONAL,
                'Integer prefix for document id',
                null
            );
    }

    protected function getParameters(InputInterface $input)
    {
        $parameters = array(
            'input'         => $input->getArgument('file'),
            'output'        => $input->getOption('output'),
            'channel'       => $input->getOption('channel'),
            'slug'          => $input->getOption('slug'),
            'id'            => array(
                'field'     => $input->getOption('idField'),
                'prefix'    => $input->getOption('idPrefix'),
            ),
            'format'        => ucfirst($input->getOption('format')),
            'formatOutput'  => ($input->getOption('pretty') === 'true') ? true : false,
        );

        return $parameters;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = $this->getParameters($input);
        $validator = new InputValidator();

        if ($validator->validateInputParameters($parameters)) {
            $converter = '\\Gpupo\Pipe2\Converter\\'.$parameters['format'].'Converter';
            $convert = new $converter($parameters);
            $output->writeln($convert->execute()->getDocument()->saveXml());
        }
    }
}
