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

namespace Gpupo\Pipe2\Converter;

class InputValidator
{
    public function validateInputParameters(Array $parameters)
    {
        if ($parameters['format'] !== 'Blank' && !file_exists($parameters['input'])) {
            throw new \InvalidArgumentException('Input File not found');
        }

        return true;
    }
}
