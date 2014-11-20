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

    protected function normalizePrice($value)
    {
        $strpos = function($needle) use ($value) {
            return strpos($value, $needle);
        };

        $decimalSeparator = ".";

        if (($strpos(',') !== false) && ($strpos('.') === false || $strpos(',') > $strpos('.'))) {
                $decimalSeparator = ",";
        }

        $normalized = str_replace(',', '.', preg_replace("/([^0-9\\" . $decimalSeparator . "])/i", "", $value));
        
        return $normalized;
    }

    protected function normalizeSalePrice($value)
    {
        return $this->normalizePrice($value);
    }
}
