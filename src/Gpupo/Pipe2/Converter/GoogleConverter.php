<?php

namespace Gpupo\Pipe2\Converter;

use Gpupo\CommonSchema\Sphinx\GoogleSchema;

class GoogleConverter extends ConverterAbstract implements ConverterInterface
{
    public function setSchema()
    {
        $this->schema = new GoogleSchema;
    }
}
