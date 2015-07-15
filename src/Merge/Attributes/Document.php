<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Pipe2\Merge\Attributes;

use Gpupo\Pipe2\DocumentAbstract;

class Document extends DocumentAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->docset = $this->createElement('channel');
        $rss = $this->createElement('rss');
        $rss->appendChild($this->docset);
        $this->appendChild($rss);
    }

}
