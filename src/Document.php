<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Pipe2;

use Gpupo\CommonSchema\SchemaInterface;

/**
 * @see http://sphinxsearch.com/docs/current.html#xmlpipe2
 */
class Document extends \DOMDocument
{
    public $docset;

    public function __construct(SchemaInterface $schema, $slug = false)
    {
        parent::__construct();
        $this->encoding = 'utf-8';
        $comment = $this->createComment('Generate by Pipe2 on '.date('r').' | See https://github.com/gpupo/pipe2');
        $this->appendChild($comment);
        $this->docset = $this->createElement('sphinx:docset');
        $this->appendChild($this->docset);
        $elements = $this->createElement('sphinx:schema');

        foreach ($schema->getSchema() as $type => $list) {
            foreach ($list as $key => $prop) {
                $elements->appendChild($this->factoryTag($type, $key, $prop));
            }
        }

        if ($slug) {
            foreach ($schema->getSluggables() as $key) {
                $elements->appendChild($this->factoryTag('field', $key.'_slug', ['attr' => 'string']));
            }
        }

        $this->docset->appendChild($elements);
    }

    protected function factoryTag($type, $key, $prop)
    {
        $tag = $this->createElement('sphinx:'.$type);

        if (is_array($prop)) {
            $tag->setAttribute('name', $key);
            foreach ($prop as $k => $v) {
                $tag->setAttribute($k, $v);
            }
        } else {
            $tag->setAttribute('name', $prop);
        }

        return $tag;
    }
}
