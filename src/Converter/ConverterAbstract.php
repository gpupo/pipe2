<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Pipe2\Converter;

use Gpupo\Pipe2\Document;

abstract class ConverterAbstract
{
    protected $input;
    protected $output;
    protected $channel;
    protected $slug;
    protected $idParameters;
    protected $document;
    protected $schema;
    protected $normalizer;

    public function __construct(Array $parameters)
    {
        $this->input = $parameters['input'];
        $this->output = $parameters['output'];
        $this->channel = $parameters['channel'];
        $this->slug = $parameters['slug'];
        $this->idParameters = $parameters['id'];
        $this->setSchema();
        $this->setNormalizer();
        $this->factoryDocument($parameters['formatOutput']);
    }

    protected function factoryDocument($formatOutput)
    {
        $this->document = new Document($this->schema, $this->slug);
        $this->document->formatOutput = $formatOutput;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getNormalizer()
    {
        return $this->normalizer;
    }

    public function execute()
    {
        $this->appendItens($this->parser());

        return $this;
    }

    protected function appendItens($list)
    {
        foreach ($list as $item) {
            $itemElement = $this->document->createElement('sphinx:document');
            $id = $this->idParameters['prefix'].$item[$this->idParameters['field']];
            $itemElement->setAttribute('id', $id);

            if (!array_key_exists('sku', $item) || empty($item['sku'])) {
                $item['sku'] = $id;
            }

            foreach ($item as $key => $value) {
                $tag = $this->document->createElement($key);
                $tag->appendChild(
                    $this->document->createTextNode($value)
                );

                $itemElement->appendChild($tag);
            }

            $this->document->docset->appendChild($itemElement);
        }
    }

    protected function fieldReduce(Array $item)
    {
        $list = array();

        foreach ($item as $value) {
            $value['tag'] = $this->schema->normalizeFieldName($value['tag']);
            if ($this->schema->tagInSchema($value['tag'])) {
                $list[] = $value;
            }
        }

        return $list;
    }

    protected function extended($item)
    {
        return $item;
    }

    protected function addSlugs(Array $item)
    {
        if (empty($this->slug)) {
            return $item;
        }

        foreach ($this->schema->getSluggables() as $key) {
            if (array_key_exists($key, $item)) {
                $item[$key.'_slug'] = $this->getNormalizer()->slugify($item[$key]);
            }
        }

        return $item;
    }

    protected function parser()
    {
        $list = array();

        foreach ($this->parser_create() as $data) {
            if ($data['tag'] !== 'item') {
                continue;
            }

            $item = array(
                'channel' => $this->channel,
            );
            foreach ($data['item'] as $product) {
                if (array_key_exists('tag', $product) && array_key_exists('value', $product)) {
                    $item[$product['tag']] = $product['value'];
                }
            }

            $normalized = $this->getNormalizer()->normalizeArrayValues($this->schema->getKeys(), $item);

            $list[$item['id']] = $this->addSlugs($this->extended($normalized));
        }

        return $list;
    }

    protected function parser_create()
    {
        $list = array();

        $doc = new \DOMDocument();
        if (@$doc->load($this->input)) {
            $xml = $doc->saveXML();
            $values = $index = array();
            $parser = xml_parser_create();
            xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
            xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
            xml_parse_into_struct($parser, $xml, $values, $index);
            xml_parser_free($parser);

            foreach ($index as $k => $v) {
                if ($k === 'item') {
                    for ($i = 0; $i < count($v); $i += 2) {
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
        }

        return $list;
    }
}
