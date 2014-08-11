<?php

namespace Gpupo\Pipe2\Converter;

use Gpupo\CommonSchema\Sphinx\GoogleSchema;

class BlankConverter extends GoogleConverter
{
    protected function parser()
    {
        return array(
            array(
                'sku' => '01',
                'title' => 'blank',
                'description' => 'blank',
                'category' => '',
                'type' => 'document',
                'brand' => '',
                'size' => '',
                'color' => '',
                'gender' => '',
                'link' => '',
                'id' => '01',
                'price' => '',
                'sale_price' => '',
                'sale_price_effective_date' => '',
                'mpn' => '',
                'image_link' => '',
                'condition' => '',
                'availability' => '',
                'age_group' => '',
                'shipping_weight' => '',
                'online_only' => '',
                'installment_months' => '',
                'installment_amount' => '',
                'review_count' => '',
                'review_average' => '',
            )
        );
    }
}
