<?php

namespace Gpupo\Pipe2;

abstract class ConverterAbstract
{
    protected $input;
    protected $output;

    public function __construct($input, $output)
    {
        $this->input = $input;
        $this->ouput = $output;
    }

    public function execute()
    {
        $parsed = $this->parser($this->load());

        return $this->createXmlPipe2($parsed);
    }

    public function load()
    {
        $doc = new \DOMDocument;
        $doc->load($this->input);

        return $doc->saveXML();
    }

}
