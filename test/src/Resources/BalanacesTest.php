<?php

namespace Edcs\Mondo\Test\Resources;

use Edcs\Mondo\Resources\Balances;
use Edcs\Mondo\Test\TestCase;
use Exception;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use Mockery as m;

class BalanacesTest extends TestCase
{
    /**
     * Ensures that a balanace entity is retured by the balances resource.
     */
    public function testBalanceGet()
    {
        $json = [
            'balance'     => uniqid(),
            'currency'    => uniqid(),
            'spend_today' => uniqid()
        ];

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andReturn(new Response(200, [], json_encode($json)));

        $balances = new Balances($client);

        $entity = $balances->get(uniqid());

        $this->assertEquals($json['balance'], $entity->getBalance());
        $this->assertEquals($json['currency'], $entity->getCurrency());
        $this->assertEquals($json['spend_today'], $entity->getSpendToday());
    }

    /**
     * Ensures that a 401 response from the api can be handled.
     *
     * @expectedException \Edcs\Mondo\Exceptions\HttpException
     */
    public function testBalanceGetNonAuthenticated()
    {
        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andThrow(
                   Exception::class,
                   'Client error: `GET https://api.getmondo.co.uk/balance` '.
                   'resulted in a `401 UNAUTHORIZED` response: {}',
                   401
               );

        $accounts = new Balances($client);

        $accounts->get(uniqid());
    }
}
