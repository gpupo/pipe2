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

namespace Gpupo\Pipe2;

abstract class DocumentAbstract extends \DOMDocument implements DocumentInterface
{
    const ENCONDING = 'utf-8';
    
    public $docset;

    protected $elementPrefix = '';

    public function __construct()
    {
        parent::__construct("1.0", self::ENCONDING);
        $comment = $this->createComment(' Generate by Pipe2 on ['.date('r')
            .'] | For more information, see <http://www.g1mr.com/pipe2/> ');
        $this->appendChild($comment);
    }

    /**
     * Factory DOMElement
     * @param  string $type
     * @param  string $key
     * @param  mixed $prop
     * @return \DOMElement
     */
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
