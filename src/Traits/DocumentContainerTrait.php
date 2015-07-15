<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Pipe2\Traits;

use Gpupo\Pipe2\DocumentAbstract;

trait DocumentContainerTrait
{
    protected $document;

    public function getDocument()
    {
        return $this->document;
    }

    protected function setDocument(DocumentAbstract $document, $formatOutput = false)
    {
        $this->document = $document;
        $this->document->formatOutput = $formatOutput;

        return $this;
    }

    protected function populateDocument($itemElement, $item)
    {
        foreach ($item as $key => $value) {
            $tag = $this->document->createElement($key);
            $tag->appendChild(
                $this->document->createTextNode($value)
            );

            $itemElement->appendChild($tag);
        }

        $this->document->docset->appendChild($itemElement);

        return $this;
    }
}
