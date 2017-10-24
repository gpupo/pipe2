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

namespace Gpupo\Pipe2\Documentor;

use Symfony\Component\Console\Command\Command as Core;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends Core
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('documentor')
            ->setDescription('Generate Markdown Documentation from PhpUnit XML')
            ->addArgument(
                'inputFile',
                InputArgument::REQUIRED,
                'PhpUnit Xml file path'
            )
            ->addArgument(
                'outputFile',
                InputArgument::REQUIRED,
                'Output file path'
            );
    }

    protected function getParameters(InputInterface $input)
    {
        $parameters = [];

        foreach (['inputFile', 'outputFile'] as $argument) {
            $parameters[$argument] = $input->getArgument($argument);
        }

        return $parameters;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = $this->getParameters($input);
        $validator = new InputValidator();

        if ($validator->validateInputParameters($parameters)) {
            $converter = new Converter($parameters);
            $output->writeln('Generated '.$parameters['outputFile']);
        }
    }
}
