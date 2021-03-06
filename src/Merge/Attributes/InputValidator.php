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

class InputValidator
{
    public function validateInputParameters(Array $parameters)
    {
        foreach (['firstDocument', 'secondDocument'] as $key) {
            $filePath = $parameters[$key];
            if (!file_exists($filePath)) {
                throw new \InvalidArgumentException('Input File '.$filePath.' not found');
            }
        }

        return true;
    }
}
