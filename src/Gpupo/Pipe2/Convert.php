<?php

namespace Gpupo\Pipe2;

class Convert extends ConverterAbstract
{
    protected $schema = array(
        'field' => array(
            'title'                     => array('attr' => 'string'),
            'description'               => array('attr' => 'string'),
            'gtin'                      => array('attr' => 'string'),
            'google_product_category'   => array('attr' => 'string'),
            'product_type'              => array('attr' => 'string'),
            'brand'                     => array('attr' => 'string'),
            'size'                      => array('attr' => 'string'),
            'color'                     => array('attr' => 'string'),
        ),
        'attr' => array(
            'link'                      => array('type' => 'string'),
            'id'                        => array('type' => 'int', 'bits' => 20),
            'price'                     => array('type' => 'float'),
            'sale_price'                => array('type' => 'float'),
            'sale_price_effective_date' => array('type' => 'string'),
            'mpn'                       => array('type' => 'string'),
            'image_link'                => array('type' => 'string'),
            'condition'                 => array('type' => 'string'),
            'availability'              => array('type' => 'string'),
            'gender'                    => array('type' => 'string'),
            'age_group'                 => array('type' => 'string'),
            'shipping_weight'           => array('type' => 'string'),
            'adwords_redirect'          => array('type' => 'string'),
            'online_only'               => array('type' => 'string'),
            'installment_months'        => array('type' => 'int', 'bits' => 5),
            'installment_amount'        => array('type' => 'float'),
            'product_review_count'      => array('type' => 'int', 'bits' => 5),
            'product_review_average'    => array('type' => 'int', 'bits' => 5),
        ),
    );

    protected function tagInSchema($tag)
    {
        $array = array_merge($this->schema['field'],$this->schema['attr']);

        if (in_array($tag, $array)) {
            return true;
        }

        if (array_key_exists($tag, $array)) {
            return true;
        }

        return false;
    }

    protected function normalizeTagName($name)
    {
        $tag = str_replace('g:', '', $name);

        if (in_array($tag, array('months', 'amount'))) {
            $tag = 'installment_' . $tag;
        }

        return $tag;
    }

    protected function fieldReduce(Array $item)
    {
        $list = array();
        foreach ($item as $value) {
            $value['tag'] = $this->normalizeTagName($value['tag']);

            if ($this->tagInSchema($value['tag'])) {
                $list[] = $value;
            }
        }

        return $list;
    }

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
                    $item = $this->fieldReduce(array_slice($values, $offset, $len));

                    if (!empty($item)) {
                        $list[$count]['item'] = $item;
                    }
                }

                break;
            }

            $list[] = $values[$v[0]];
        }

        return $list;
    }

    protected function createXmlPipe2($dataXml)
    {
        $doc = new Document($this->schema, $dataXml);

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
