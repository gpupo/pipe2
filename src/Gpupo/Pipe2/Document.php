<?php

namespace Gpupo\Pipe2;

use Gpupo\CommonSchema\SchemaInterface;

/**
 * @see http://sphinxsearch.com/docs/current.html#xmlpipe2
 */
class Document extends \DOMDocument
{
    public $docset;

    public function __construct(SchemaInterface $schema)
    {
        parent::__construct();
        $this->encoding = 'utf-8';
        $this->docset = $this->createElement("sphinx:docset");
        $this->appendChild( $this->docset );
        $elements = $this->createElement("sphinx:schema");

        foreach ($schema->getSchema() as $type => $list) {
            foreach($list as $key => $prop) {
                $elements->appendChild($this->factoryTag($type, $key, $prop));
            }
        }

        $this->docset->appendChild($elements);
    }

    protected function factoryTag($type, $key, $prop)
    {
        $tag = $this->createElement('sphinx:' . $type);

        if (is_array($prop)) {
            $tag->setAttribute('name', $key);
            foreach($prop as $k => $v) {
                $tag->setAttribute($k, $v);
            }
        } else {
            $tag->setAttribute('name', $prop);
        }

        return $tag;
    }
}
