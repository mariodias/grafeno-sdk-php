<?php

namespace Grafeno\Helpers;

/**
 * trait Utils.
 */
trait Utils
{
    /**
     * Compiles a string with markup into an interpolation.
     *
     * @param $content
     * @param array $data
     *
     * @return mixed
     */
    protected function interpolate($content, array $data = [])
    {
        foreach ($data as $key=>$value) {
            $content = str_replace('{'.$key.'}', $value, $content);
        }

        return $content;
    }
}
