<?php

namespace Gpupo\Pipe2;

class GenerateCommand extends ConvertCommand
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('generate')
            ->setDescription('Generate blank Document xmlpipe2 format');

    }
}
