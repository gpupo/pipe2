<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <contact@gpupo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For more information, see
 * <https://opensource.gpupo.com/pipe2/>.
 */

namespace Gpupo\Pipe2\Normalizer;

interface NormalizerInterface
{
    public function slugify($value);
    public function normalize($field, $value);
    public function normalizeArrayValues(Array $keys, Array $item);
}
