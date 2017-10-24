<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <contact@gpupo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For more information, see
 * <https://opensource.gpupo.com/pipe2/>.
 */

namespace Gpupo\Pipe2\Merge\Attributes;

use Symfony\Component\Console\Command\Command as Core;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends Core
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('merge-attributes')
            ->setDescription('Merge XML Documents with Similar Structure Where Second Document Contains Attributes')
            ->addArgument(
                'firstDocument',
                InputArgument::REQUIRED,
                'First Document Xml file path'
            )
            ->addArgument(
                'secondDocument',
                InputArgument::REQUIRED,
                'Second Document Xml file path'
            )
            ->addOption(
                'idField',
                null,
                InputOption::VALUE_OPTIONAL,
                'Item field to fill document id',
                'id'
            )->addOption(
                'pretty',
                null,
                InputOption::VALUE_OPTIONAL,
                'Nicely formats output with indentation and extra space',
                false
            );
    }

    protected function getParameters(InputInterface $input)
    {
        $parameters = [
            'idField'       => $input->getOption('idField'),
            'formatOutput'  => ($input->getOption('pretty') === 'true') ? true : false,
        ];

        foreach (['firstDocument', 'secondDocument'] as $argument) {
            $parameters[$argument] = $input->getArgument($argument);
        }

        return $parameters;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = $this->getParameters($input);
        $validator = new InputValidator();

        if ($validator->validateInputParameters($parameters)) {
            $combiner = new Combiner($parameters);
            $output->writeln($combiner->getDocument()->saveXml());
        }
    }
}
