<?php

namespace Gpupo\Pipe2\Normalizer;

interface NormalizerInterface
{
    public function slugify($value);
    public function normalize($field, $value);
    public function normalizeArrayValues(Array $keys, Array $item);
}