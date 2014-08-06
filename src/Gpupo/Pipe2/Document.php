<?php

namespace Gpupo\Pipe2;

/**
 * @see http://sphinxsearch.com/docs/current.html#xmlpipe2
 */
class Document extends \DOMDocument
{
    public $docset;

    public function __construct($config, $dataXml)
    {
        parent::__construct();

        $this->formatOutput = true;
        $this->encoding = 'utf-8';

        $this->docset = $this->createElement( "sphinx:docset" );
        $this->appendChild( $this->docset );
        $sphinx_schema = $this->createElement( "sphinx:schema" );

        foreach ($dataXml as $data) {
        if ($data['tag']!='item') {
        continue;
        }
        foreach ($data['item'] as $tags) {
            if ($tags['type']=='open') {
                continue;
            }
            if (in_array($tags['tag'], $config['field'])) {
                $type = 'sphinx:field';
            } else {
                $type = 'sphinx:attr';
            }
            $tag = $this->createElement($type);
            $tag->setAttribute('name', $tags['tag']);
            $sphinx_schema->appendChild( $tag );
        }
        break;
        }

        $this->docset->appendChild( $sphinx_schema );
    }
}
