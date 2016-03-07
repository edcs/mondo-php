<?php

namespace Edcs\Mondo\Support;

class Str
{
    /**
     * Converts a string from camel case to snake case.
     *
     * @param string $str
     * @return string
     */
    public static function camelToSnake($str)
    {
        $str[0] = strtolower($str[0]);

        return preg_replace_callback('/([A-Z])/', function ($string) {
            return '_' . strtolower($string[1]);
        }, $str);
    }
}
