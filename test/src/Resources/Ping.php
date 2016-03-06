<?php

namespace Edcs\Mondo\Test\Resources;

use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use Mockery as m;
use PHPUnit_Framework_TestCase;

class Ping extends PHPUnit_Framework_TestCase
{
    /**
     * Ensures that a valid entity is returned when you call who am I on the ping resource.
     */
    public function testWhoAmIEndpoint()
    {
        $json = [
            'authenticated' => (boolean) rand(0, 1),
            'client_id' => uniqid(),
            'user_id' => uniqid()
        ];

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->andReturn(new Response(200, [], json_encode($json)));

        $ping = new \Edcs\Mondo\Resources\Ping($client);

        $response = $ping->whoAmI();

        $this->assertEquals($json['authenticated'], $response->getAuthenticated());
        $this->assertEquals($json['client_id'], $response->getClientId());
        $this->assertEquals($json['user_id'], $response->getUserId());
    }

    /**
     * Ensures that a 401 response from the api can be handled.
     *
     * @expectedException \Edcs\Mondo\Exceptions\HttpException
     */
    public function testWhoAmIEndpointNonAuthenticated()
    {
        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->andReturn(new Response(401));

        $ping = new \Edcs\Mondo\Resources\Ping($client);

        $ping->whoAmI();
    }
}
