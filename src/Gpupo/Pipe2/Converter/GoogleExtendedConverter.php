<?php

namespace Gpupo\Pipe2\Converter;

use Gpupo\CommonSchema\Sphinx\GoogleExtendedSchema;
use Gpupo\Pipe2\Normalizer\GoogleExtendedNormalizer;

class GoogleExtendedConverter extends GoogleConverter
{
    public function setSchema()
    {
        $this->schema = new GoogleExtendedSchema;
    }

    public function setNormalizer()
    {
        $this->normalizer = new GoogleExtendedNormalizer;
    }

    protected function extended($item)
    {
        if ($item['sale_price']) {
            $item['sale_price_discount'] = $item['price'] - $item['sale_price'];
            $item['sale_price_percentage'] =  ($item['price'] - $item['sale_price'])/$item['price'] * 100;
        }

        return $item;
    }
}
