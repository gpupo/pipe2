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

namespace Gpupo\Pipe2\Converter;

use Gpupo\CommonSchema\Sphinx\GoogleSchema;
use Gpupo\Pipe2\Normalizer\GoogleNormalizer;

class GoogleConverter extends ConverterAbstract implements ConverterInterface
{
    public function setSchema()
    {
        $this->schema = new GoogleSchema();
    }

    public function setNormalizer()
    {
        $this->normalizer = new GoogleNormalizer();
    }
}
