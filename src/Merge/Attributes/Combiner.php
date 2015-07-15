<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Pipe2\Merge\Attributes;

use Gpupo\Pipe2\Traits\ParserTrait;
use Gpupo\Pipe2\Traits\DocumentContainerTrait;
use Gpupo\Common\Entity\Collection;
use Gpupo\Common\Entity\CollectionInterface;

class Combiner
{
    use ParserTrait;
    use DocumentContainerTrait;

    protected $idKey = 'id';

    public function __construct(Array $parameters)
    {
        $this->setDocument(new Document());

        $this->idKey = 'g:id';

        $firstDocument = $this->factoryCollectionFromFilePath($parameters['firstDocument']);
        $secondDocument = $this->factoryCollectionFromFilePath($parameters['secondDocument']);
        $this->combine($firstDocument, $secondDocument);
    }

    protected function factoryCollectionFromFilePath($filePath)
    {
        return new Collection($this->parserProcess($this->parserFromFile($filePath)));
    }

    protected function parserProcess(Array $raw)
    {
        $list = [];

        foreach ($raw as $data) {
            if ($data['tag'] !== 'item') {
                continue;
            }
            $item = $this->parserItems($data);
            $list[$item[$this->idKey]] = new Collection($item);
        }

        return $list;
    }

    protected function combine(CollectionInterface $first, CollectionInterface $second)
    {
        foreach($first as $item) {
            $key =  $item->get($this->idKey);
            if($second->containsKey($key)) {
                foreach($second->get($key) as $field => $value)
                {
                    if (!$item->containsKey($field)) {
                        $item->set($field, $value);
                    }
                }
            }
        }
        return $first;
    }

}
