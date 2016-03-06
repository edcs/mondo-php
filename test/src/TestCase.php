<?php

namespace Edcs\Mondo\Test;

use Mockery as m;
use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Closes mockery down after each test.
     *
     * @after
     */
    public function closeMockery()
    {
        m::close();
    }
}
