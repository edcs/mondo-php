<?php
namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Entitites\Ping\WhoAmI;
use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;

class Ping
{
    /**
     * Instance of the http client.
     *
     * @var HttpClient
     */
    private $client;

    /**
     * Ping constructor.
     *
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Returns information about the current access token.
     *
     * @return WhoAmI
     */
    public function whoAmI()
    {
        $request = new Request('get', '/ping/whoami');
        $response = $this->client->sendRequest($request);

        return new WhoAmI($response);
    }
}
