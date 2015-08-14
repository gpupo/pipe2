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

use Gpupo\Common\Entity\CollectionAbstract;
use Gpupo\Common\Entity\CollectionInterface;

class Collection extends CollectionAbstract implements CollectionInterface
{
    protected $meta;

    public function setMeta(Array $meta)
    {
        $this->meta = new self($meta);
    }

    public function getMeta()
    {
        if (empty($this->meta)) {
            $this->setMeta([]);
        }

        return $this->meta;
    }
}
