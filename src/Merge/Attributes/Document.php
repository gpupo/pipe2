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
    public function __construct(Collection $meta)
    {
        parent::__construct();
        $this->docset = $this->createElement('channel');
        $rss = $this->createElement('rss');

        if ($meta->containsKey('rss')) {
            foreach($meta->get('rss') as $attr => $value) {
                $rss->setAttribute($attr, $value);
            }
        }

        foreach($meta as $key => $value) {

            if (empty($value)){
                continue;
            }

            if (is_array($value)) {

            } else {
                $new = $this->createElement($key, $value);
            }
            if (isset($new)) {
                $this->docset->appendChild($new);
                unset($new);
            }
        }

        $rss->appendChild($this->docset);
        $this->appendChild($rss);
    }
}
