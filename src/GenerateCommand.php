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

namespace Gpupo\Pipe2;

use Gpupo\Pipe2\Converter\Command;
use Symfony\Component\Console\Input\InputInterface;

class GenerateCommand extends Command
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
