<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For more information, see
 * <http://www.g1mr.com/pipe2/>.
 */

namespace Gpupo\Pipe2\Documentor;

use Gpupo\Common\Entity\Collection;
use Gpupo\Pipe2\Traits\DocumentContainerTrait;
use SimpleXmlElement;

class Converter
{
    use DocumentContainerTrait;

    protected $list;

    public function getMarkdown()
    {
        return $this->getDocument()->render($this->list);
    }

    public function __construct(Array $parameters)
    {
        $this->setDocument(new Document());
        $this->list = $this->parserFromFile($parameters['inputFile']);

        file_put_contents($parameters['outputFile'], $this->getMarkdown());
    }

    protected function parserFromFile($file)
    {
        $xml = simplexml_load_file($file);

        return $this->parseItens($xml);
    }

    protected function normalizeFullName($fullName)
    {
        return ltrim((string) $fullName, '\\');
    }

    protected function parseParent($raw)
    {
        $list = [];
        if (!empty($raw)) {
            foreach ($raw as $parent) {
                $list[] = ltrim((string) $parent, '\\');
            }
        }

        return $list;
    }

    protected function parseItens(SimpleXmlElement $xml)
    {
        $list = [];
        foreach ($xml->xpath('file/class|file/interface') as $class) {
            $name = $this->normalizeFullName($class->full_name);
            $list[$name] = [
                'className'       => $name,
                'shortClass'      => $class->name,
                'namespace'       => $class['namespace'],
                'description'     => $class->docblock->description,
                'longDescription' => $class->docblock->{'long-description'},
                'implements'      => $this->parseParent($class->implements),
                'extends'         => $this->parseParent($class->extends),
                'methods'         => $this->parseMethods($class),
            ];
        }

        return new Collection($list);
    }

    protected function parseMethods(SimpleXMLElement $class)
    {
        $list = [];

        foreach ($class->method as $method) {
            $list[] = $this->parserMethod($method);
        }

        return $list;
    }

    protected function parseArgument($method)
    {
        $list = [];
        foreach ($method->argument as $argument) {
            $data = get_object_vars($argument);

            if ($data['type'] && is_object($data['type'])) {
                $data['type'] = get_object_vars($data[$type]);
            }

            $filter = 'docblock/tag[@name="param" and @variable="'.$data['name'].'"]';

            $tag = $method->xpath($filter);

            $list[] = $data;
        }

        return new Collection($list);
    }

    protected function parserMethod($method)
    {
        return new Collection([
            'name'        => $method->name,
            'description' => (string) $method->docblock->description."\n\n".(string) $method->docblock->{'long-description'},
            'visibility'  => (string) $method['visibility'],
            'static'      => ((string) $method['static']) === 'true',
            'arguments'   => $this->parseArgument($method),
        ]);
    }
}
