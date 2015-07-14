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
