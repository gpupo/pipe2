<?php

namespace Gpupo\Pipe2\Normalizer;

class GoogleExtendedNormalizer extends GoogleNormalizer
{
    protected function normalizeGender($value)
    {
        $array = array (
            'masculino'     => 'male',
            'feminino'      => 'female',
            'unissex'       => 'unisex',
            ''              => 'unisex',
        );

        return str_replace(array_keys($array), $array, strtolower($value));
    }
}
