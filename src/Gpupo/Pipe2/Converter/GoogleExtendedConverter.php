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
        if (array_key_exists('sale_price', $item) && !empty($item['sale_price'])) {
            $item['sale_price_discount'] = $item['price'] - $item['sale_price'];
            $item['sale_price_percentage'] =  ($item['price'] - $item['sale_price'])/$item['price'] * 100;
        }

        $parts = array();

        foreach (array('title', 'color', 'size', 'id' , 'brand', 'channel', 'category', 'sku') as $key) {
            if (array_key_exists($key, $item)) {
                $parts[] = $item[$key];
            }
        }

        $item['document_slug'] = $this->getNormalizer()->slugify(implode('-', $parts));

        return $item;
    }
}
