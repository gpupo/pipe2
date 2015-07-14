<?php

/*
 * This file is part of gpupo/pipe2
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Pipe2\Normalizer;

class GoogleExtendedNormalizer extends GoogleNormalizer
{
    protected function normalizeGender($value)
    {
        $array = array(
            'masculino'     => 'male',
            'feminino'      => 'female',
            'unissex'       => 'unisex',
            ''              => 'unisex',
        );

        return str_replace(array_keys($array), $array, strtolower($value));
    }

    protected function normalizePrice($value)
    {
        $strpos = function ($needle) use ($value) {
            return strpos($value, $needle);
        };

        $decimalSeparator = '.';

        if (($strpos(',') !== false) && ($strpos('.') === false || $strpos(',') > $strpos('.'))) {
            $decimalSeparator = ',';
        }

        $normalized = str_replace(',', '.', preg_replace('/([^0-9\\'.$decimalSeparator.'])/i', '', $value));

        return $normalized;
    }

    protected function normalizeSalePrice($value)
    {
        return $this->normalizePrice($value);
    }
}
