<?php

namespace Gpupo\Pipe2;

use Symfony\Component\Console\Input\InputInterface;

class GenerateCommand extends ConvertCommand
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('generate')
            ->setDescription('Generate blank Document xmlpipe2 format');

    }

    protected function getParameters(InputInterface $input)
    {
        $parameters = parent::getParameters($input);
        $parameters['input'] = '/dev/null';

        return $parameters;
    }
}
