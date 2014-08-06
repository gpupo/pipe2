<?php

namespace Gpupo\Pipe2;

class Convert extends ConverterAbstract
{
    protected $config = array(
        'field' => array(
            'title',
            'description',
            'gtin',
            'google_product_category',
            'product_type',
            'brand',
            'size',
            'color',
        ),
        'attr' => array(
            'link',
            'id',
            'product_type',
            'price',
            'sale_price_effective_date',
            'mpn',
            'image_link',
            'condition',
            'availability',
            'gender',
            'age_group',
            'shipping_weight',
            'adwords_redirect',
            'online_only',
            'installment',
            'product_review_count',
            'product_review_average',
        ),
    );

    protected function parser($xml)
    {
        $values = $index = array();
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $values, $index);
        xml_parser_free($parser);

        foreach ($index as $k => $v) {
            if ($k === "item") {

                for ($i=0; $i < count($v); $i+=2) {
                    $count = (empty($count) ? $v[$i] : ++$count);
                    $offset = $v[$i] + 1;
                    $len = $v[$i + 1] - $offset;
                    $list[$count] = $values[$v[0]];
                    $item = array_slice($values, $offset, $len);

                    $list[$count]['item'] = array_map(function ($value) {
                        $value['tag'] = str_replace('g:', '', $value['tag']);

                        return $value;
                    }, $item);
                }

                break;
            }

            $list[] = $values[$v[0]];
        }

        return $list;
    }

    protected function createXmlPipe2($dataXml)
    {
        $doc = new Document($this->config, $dataXml);

        foreach ($dataXml as $data) {
            if ($data['tag']!='item') {
                continue;
            }
            $b = $doc->createElement( "sphinx:document" );
            $b->setAttribute('id', $data['item'][0]['value']);
            $target = 'b';
            foreach ($data['item'] as $product) {
                $tag = $doc->createElement( $product['tag'] );
                if (array_key_exists('value', $product)) {
                    $tag->appendChild(
                        $doc->createTextNode( $product['value'] )
                    );
                }
                if ($product['type']==='complete') {
                    $$target->appendChild( $tag );
                } elseif ($product['type']==='open') {
                    $c = $tag;
                    $target = 'c';
                    continue;
                } elseif ($product['type']==='close') {
                    $target = 'b';
                    $$target->appendChild( $c );
                }
            }

            $doc->docset->appendChild( $b );
        }

        return $doc->saveXML();
    }
}
