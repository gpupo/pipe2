<?php

namespace Gpupo\Pipe2\Converter;

use Gpupo\CommonSchema\Sphinx\GoogleSchema;

class BlankConverter extends GoogleConverter
{
    public function execute()
    {
        return $this;
    }

}
