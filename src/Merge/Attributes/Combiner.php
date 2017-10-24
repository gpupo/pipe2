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

namespace Gpupo\Pipe2\Merge\Attributes;

use Gpupo\Common\Entity\CollectionInterface;
use Gpupo\Pipe2\Traits\DocumentContainerTrait;
use Gpupo\Pipe2\Traits\ParserTrait;

class Combiner
{
    use ParserTrait;
    use DocumentContainerTrait;

    protected $idField;

    protected function getIdField()
    {
        return $this->idField;
    }

    public function __construct(Array $parameters)
    {
        $this->idField = $parameters['idField'];
        $firstDocument = $this->factoryCollectionFromFilePath($parameters['firstDocument']);
        $secondDocument = $this->factoryCollectionFromFilePath($parameters['secondDocument']);
        $this->setDocument(new Document($firstDocument->getMeta()), $parameters['formatOutput']);
        $this->appendItens($this->combine($firstDocument, $secondDocument));
    }

    protected function factoryCollectionFromFilePath($filePath)
    {
        $data = $this->parserFromFile($filePath);

        $collection  =  new Collection($this->parserProcess($data));
        $collection->setMeta($this->parserMetas($data));

        return $collection;
    }

    protected function hasKey($item)
    {
        if ($item instanceof CollectionInterface && $item->containsKey($this->getIdField())) {
            return true;
        }

        if (array_key_exists($this->getIdField(), $item)) {
            return true;
        }
        error_log('Warning:Item Field ['.$this->getIdField().'] not found. Try setup --idField options.');

        return false;
    }

    protected function parserProcess(Array $raw)
    {
        $list = [];

        foreach ($raw as $data) {
            if ($data['tag'] !== 'item') {
                continue;
            }
            $item = $this->parserItems($data);

            if ($this->hasKey($item)) {
                $list[$item[$this->getIdField()]] = new Collection($item);
            }
        }

        return $list;
    }

    protected function parserMetas(Array $raw)
    {
        $list = [];

        foreach ($raw as $data) {
            if ($data['tag'] === 'item') {
                continue;
            }
            if (array_key_exists('attributes', $data)) {
                $list[$data['tag']] = $data['attributes'];
            } elseif (array_key_exists('value', $data)) {
                $list[$data['tag']] = $data['value'];
            }
        }

        return $list;
    }

    protected function combine(CollectionInterface $first, CollectionInterface $second)
    {
        foreach ($first as $item) {
            if (!$this->hasKey($item)) {
                continue;
            }
            $key =  $item->get($this->idField);

            if ($second->containsKey($key)) {
                foreach ($second->get($key) as $field => $value) {
                    if (!$item->containsKey($field)) {
                        $item->set($field, $value);
                    }
                }
            }
        }

        return $first;
    }

    protected function appendItens($list)
    {
        foreach ($list as $item) {
            $itemElement = $this->document->createElement('item');
            $id = $item->get($this->getIdField());
            $itemElement->setAttribute('id', $id);
            $this->populateDocument($itemElement, $item);
        }
    }
}
