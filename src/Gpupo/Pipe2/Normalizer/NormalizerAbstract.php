<?php

namespace Gpupo\Pipe2\Normalizer;

abstract class NormalizerAbstract
{
    public function normalize($field, $value)
    {
        $methodName = 'normalize' . ucfirst($field);

        if (method_exists($this, $methodName)) {
            $value = $this->$methodName($value);
        }

        return trim($value);
    }

    public function normalizeArrayValues(Array $keys, Array $item)
    {
        foreach( $keys as $field) {
            if (array_key_exists($field, $item)) {
                $item[$field] = $this->normalize($field, $item[$field]);
            }
        }

        return $item;
    }

    protected function normalizeLink($url)
    {
        $parse = parse_url($url);
        parse_str($parse['query'], $params);

        $blackList = array(
            'utm_campaign',
            'utm_source' ,
            'utm_medium',
            'utm_term',
            'utm_item',
        );

        foreach($blackList as $key) {
            unset($params[$key]);
        }

        $newUrl = '';

        if (array_key_exists('scheme', $parse)) {
            $newUrl .= $parse['scheme'] . '://';
        }

        if (array_key_exists('host', $parse)) {
            $newUrl .= $parse['host'];
        }

        $newUrl .= $parse['path'];

        if (!empty($params)) {
            $newUrl .= '?' . http_build_query($params);
        }

        return $newUrl;
    }

    protected function normalizeColor($value)
    {
        return $this->nullToUndefined($value);
    }

    protected function nullToUndefined($value)
    {
        if (empty($value)) {
            return 'undefined';
        }

        return $value;
    }
}