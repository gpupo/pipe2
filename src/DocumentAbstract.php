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
 * <http://gpupo.github.io/pipe2/>.
 */

namespace Gpupo\Pipe2;

abstract class DocumentAbstract extends \DOMDocument
{
    public $docset;

    protected $encoding = 'utf-8';

    protected $elementPrefix = '';

    public function __construct()
    {
        parent::__construct();
        $comment = $this->createComment('Generate by Pipe2 on '.date('r').' | See https://github.com/gpupo/pipe2');
        $this->appendChild($comment);
    }

    protected function factoryTag($type, $key, $prop)
    {
        $tag = $this->createElement($this->elementPrefix.$type);

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
