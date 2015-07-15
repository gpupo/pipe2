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

use Gpupo\Pipe2\Traits\ParserTrait;
use Gpupo\Pipe2\Traits\DocumentContainerTrait;

abstract class ConverterAbstract
{
    use ParserTrait;
    use DocumentContainerTrait;

    protected $input;
    protected $output;
    protected $channel;
    protected $slug;
    protected $idParameters;
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
        $this->setDocument(new Document($this->schema, $this->slug), $formatOutput);

        return $this;
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
        $list = [];

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
        $list = [];

        foreach ($this->parser_create() as $data) {
            if ($data['tag'] !== 'item') {
                continue;
            }

            $item = array_merge(['channel' => $this->channel], $this->parserItems($data));

            $normalized = $this->getNormalizer()->normalizeArrayValues($this->schema->getKeys(), $item);

            $list[$item['id']] = $this->addSlugs($this->extended($normalized));
        }

        return $list;
    }

    protected function parser_create()
    {
        return $this->parserFromFile($this->input);
    }
}
