<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <contact@gpupo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For more information, see
 * <https://opensource.gpupo.com/pipe2/>.
 */

namespace Gpupo\Pipe2\Traits;

trait ParserTrait
{
    protected function fieldReduce(Array $item)
    {
        return $item;
    }

    protected function parserItems($data)
    {
        $item = [];
        foreach ($data['item'] as $product) {
            if (array_key_exists('tag', $product) && array_key_exists('value', $product)) {
                $item[$product['tag']] = $product['value'];
            }
        }

        return $item;
    }

    protected function parserFromFile($filePath, $key = 'item')
    {
        $list = [];

        $doc = new \DOMDocument();
        if (@$doc->load($filePath)) {
            $xml = $doc->saveXML();
            $values = $index = [];
            $parser = xml_parser_create();
            xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
            xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
            xml_parse_into_struct($parser, $xml, $values, $index);
            xml_parser_free($parser);

            foreach ($index as $k => $v) {
                if ($k === $key) {
                    for ($i = 0; $i < count($v); $i += 2) {
                        $count = (empty($count) ? $v[$i] : ++$count);
                        $offset = $v[$i] + 1;
                        $len = $v[$i + 1] - $offset;
                        $list[$count] = $values[$v[0]];
                        $item = $this->fieldReduce(array_slice($values, $offset, $len));

                        if (!empty($item)) {
                            $list[$count][$key] = $item;
                        }
                    }

                    break;
                }

                $list[] = $values[$v[0]];
            }
        }

        return $list;
    }
}
