<?php

namespace Edcs\Mondo\Test\Support;

use Edcs\Mondo\Support\Str;
use Edcs\Mondo\Test\TestCase;

class StrTest extends TestCase
{
    /**
     * Ensures that a snake case string gets converted to camel case.
     */
    public function testSnakeCaseStringIsConvertedToCamelCase()
    {
        $str = 'thisIsSnakeCase';

        $this->assertEquals('this_is_snake_case', Str::camelToSnake($str));
    }

    /**
     * Ensures that a pence value is converted to a money string.
     */
    public function testNumberIsConvertedToMoneyString()
    {
        $money = 1000;

        $this->assertEquals('£10.00', Str::money($money));
    }
}
