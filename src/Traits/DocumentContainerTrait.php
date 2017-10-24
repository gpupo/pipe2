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

use DOMElement;
use Gpupo\Pipe2\DocumentInterface;

trait DocumentContainerTrait
{
    protected $document;

    public function getDocument()
    {
        return $this->document;
    }

    protected function setDocument(DocumentInterface $document, $formatOutput = false)
    {
        $this->document = $document;
        $this->document->formatOutput = $formatOutput;

        return $this;
    }

    private $_documentElementTree = [];

    protected function documentElementTreeAppend(DOMElement $tag, $parent)
    {
        if (!array_key_exists($parent, $this->_documentElementTree)) {
            $this->_documentElementTree[$parent] = $this->document->createElement($parent);
        }

        $this->_documentElementTree[$parent]->appendChild($tag);

        return $this;
    }

    protected function documentElementTreeList()
    {
        return [
            'g:installment' => ['g:months', 'g:amount'],
        ];
    }

    protected function documentElementTreeGetParent($key)
    {
        foreach ($this->documentElementTreeList() as $name => $array) {
            if (in_array($key, $array, true)) {
                return $name;
            }
        }

        return false;
    }

    protected function documentElementTreeFinal(DOMElement $itemElement)
    {
        foreach ($this->_documentElementTree as $element) {
            $itemElement->appendChild($element);
        }

        return $itemElement;
    }

    protected function populateDocument($itemElement, $item)
    {
        foreach ($item as $key => $value) {
            $tag = $this->document->createElement($key);

            if (is_numeric($value)) {
                $tag->appendChild($this->document->createTextNode($value));
            } else {
                $tag->appendChild($this->document->createCDATASection($value));
            }
            $parent = $this->documentElementTreeGetParent($key);
            if (!empty($parent)) {
                $this->documentElementTreeAppend($tag, $parent);
            } else {
                $itemElement->appendChild($tag);
            }
        }

        $this->document->docset->appendChild($this->documentElementTreeFinal($itemElement));

        return $this;
    }
}
