<?php

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
        $normalizer = new GoogleExtendedNormalizer;
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
