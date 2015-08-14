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

namespace Gpupo\Pipe2\Merge\Attributes;

use Gpupo\Pipe2\DocumentAbstract;

class Document extends DocumentAbstract
{
    public function __construct()
    {
        parent::__construct("1.0", "utf-8");
        $this->docset = $this->createElement('channel');
        $rss = $this->createElement('rss');
        $rss->setAttribute("xmlns:g","http://base.google.com/ns/1.0");
        $rss->setAttribute("version", "2.0");

        foreach(['title', 'description', 'link'] as $key) {
            $new = $this->createElement($key);
            $this->docset->appendChild($new);
        }

        $rss->appendChild($this->docset);
        $this->appendChild($rss);
    }
}
