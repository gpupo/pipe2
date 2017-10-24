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

namespace Gpupo\Tests\Pipe2\Normalizer;

use Gpupo\Pipe2\Normalizer\GoogleExtendedNormalizer;
use Gpupo\Tests\Pipe2\TestCaseAbstract;

class GoogleExtendedNormalizerTest extends TestCaseAbstract
{
    /**
     * @dataProvider dataProviderInformacao
     */
    public function test($value, $expected)
    {
        $normalizer = new GoogleExtendedNormalizer();
        $this->assertEquals($expected, $normalizer->normalize('price', $value));
    }

    public function dataProviderInformacao()
    {
        return [
            ['$1,000,000.00', 1000000.00],
            ['R$1,000,000.00', 1000000.00],
            ['R$1000000.00', 1000000.00],
            ['R$1000000.04', 1000000.04],
            ['R$ 1 000 000.04', 1000000.04],
            ['R$ 1.000.000,04', 1000000.04],
        ];
    }
}
