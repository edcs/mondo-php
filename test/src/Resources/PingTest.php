<?php

namespace Edcs\Mondo\Test\Resources;

use Edcs\Mondo\Resources\Ping;
use Edcs\Mondo\Test\TestCase;
use Exception;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use Mockery as m;

class PingTest extends TestCase
{
    /**
     * Ensures that a valid entity is returned when you call who am I on the ping resource.
     */
    public function testWhoAmI()
    {
        $json = [
            'authenticated' => (bool) rand(0, 1),
            'client_id'     => uniqid(),
            'user_id'       => uniqid(),
        ];

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andReturn(new Response(200, [], json_encode($json)));

        $ping = new Ping($client);

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
    public function testWhoAmINonAuthenticated()
    {
        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andThrow(
                   Exception::class,
                   'Client error: `GET https://api.getmondo.co.uk/` resulted in a `401 UNAUTHORIZED` response: {}',
                   401
               );

        $ping = new Ping($client);

        $ping->whoAmI();
    }
}
