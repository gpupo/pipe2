<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
            ->addArgument(
                'output',
                InputArgument::REQUIRED,
                'Output Document Xml file path'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = $this->getParameters($input);
        $validator = new InputValidator();

        if ($validator->validateInputParameters($parameters)) {

            echo 'foo';
        }
    }
}
