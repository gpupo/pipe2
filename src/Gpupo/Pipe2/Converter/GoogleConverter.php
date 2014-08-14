<?php

namespace Gpupo\Pipe2\Converter;

use Gpupo\CommonSchema\Sphinx\GoogleSchema;
use Gpupo\Pipe2\Normalizer\GoogleNormalizer;

class GoogleConverter extends ConverterAbstract implements ConverterInterface
{
    public function setSchema()
    {
        $this->schema = new GoogleSchema;
    }

    public function setNormalizer()
    {
        $this->normalizer = new GoogleNormalizer;
    }
}
