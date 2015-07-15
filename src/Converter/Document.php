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

use Gpupo\CommonSchema\SchemaInterface;
use Gpupo\Pipe2\DocumentAbstract;

/**
 * @see http://sphinxsearch.com/docs/current.html#xmlpipe2
 */
class Document extends DocumentAbstract
{
    protected $elementPrefix = 'sphinx:';

    public function __construct(SchemaInterface $schema, $slug = false)
    {
        parent::__construct();
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
}
