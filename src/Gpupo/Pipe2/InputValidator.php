<?php

namespace Gpupo\Pipe2;

class InputValidator
{

    public function validateInputParameters(Array $parameters)
    {
        if ($parameters['format'] != 'Blank' && !file_exists($parameters['input'])) {
            throw new \InvalidArgumentException('Input File not found');
        }

        return true;
    }
}