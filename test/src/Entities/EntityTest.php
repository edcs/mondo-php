<?php

namespace Edcs\Mondo\Test\Entities;

use Edcs\Mondo\Test\Stubs\EntityStub;
use Edcs\Mondo\Test\TestCase;
use GuzzleHttp\Psr7\Response;

class EntityTest extends TestCase
{
    /**
     * Ensures that the offset exists method is setup correctly.
     */
    public function testOffsetExists()
    {
        $json = ['foo' => uniqid()];

        $response = new Response(200, [], json_encode($json));

        $stub = new EntityStub($response);

        $this->assertTrue($stub->offsetExists('foo', $stub));
        $this->assertFalse($stub->offsetExists('bar', $stub));
    }

    /**
     * Ensures that the offset get method is setup correctly.
     */
    public function testOffsetGet()
    {
        $json = ['foo' => uniqid()];

        $response = new Response(200, [], json_encode($json));

        $stub = new EntityStub($response);

        $this->assertEquals($json['foo'], $stub['foo']);
    }

    /**
     * Ensures that the offset set method is setup correctly.
     */
    public function testOffsetSet()
    {
        $json = ['foo' => uniqid()];

        $response = new Response(200, [], json_encode($json));

        $stub = new EntityStub($response);

        $this->assertEquals($json['foo'], $stub['foo']);

        $stub['foo'] = $unique = uniqid();
        $stub[] = $unique;

        $this->assertEquals($unique, $stub['foo']);
        $this->assertEquals($unique, $stub[0]);
    }

    /**
     * Ensures that the offset unset method is setup correctly.
     */
    public function testOffsetUnSet()
    {
        $json = ['foo' => uniqid()];

        $response = new Response(200, [], json_encode($json));

        $stub = new EntityStub($response);

        $this->assertEquals($json['foo'], $stub['foo']);

        $stub['bar'] = $unique = uniqid();

        $stub->offsetUnset('bar');

        $this->assertFalse($stub->offsetExists('bar'));
    }
}
