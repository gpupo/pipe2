<?php

namespace Gpupo\Pipe2\Normalizer;

class GoogleExtendedNormalizer extends GoogleNormalizer
{
    protected function normalizeAvailability($value)
    {
        return str_replace(' stock', '', $value);
    }

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