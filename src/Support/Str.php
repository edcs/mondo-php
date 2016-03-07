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

    /**
     * Converts the supplied value from pence into it's decimalised format.
     *
     * @param int $pence
     * @param string $locale
     * @param string $format
     * @return string
     */
    public static function money($pence, $locale = 'en_GB.UTF-8', $format = '%n')
    {
        $value = $pence / 100;
        setlocale(LC_MONETARY, $locale);
        return money_format($format, $value);
    }
}
