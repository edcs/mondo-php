<?php

namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Exceptions\HttpException;
use Exception;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Resource
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
     * Makes an http request to the api.
     *
     * @param RequestInterface $request
     *
     * @throws HttpException
     *
     * @return ResponseInterface
     */
    protected function sendRequest(RequestInterface $request)
    {
        try {
            $response = $this->client->sendRequest($request);
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode());
        }

        if ($response->getStatusCode() >= 400) {
            throw new HttpException(
                "Client error: `{$request->getMethod()} {$request->getUri()}` resulted in a ".
                "`{$response->getStatusCode()} {$response->getReasonPhrase()}` response: ".
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );
        }

        return $response;
    }
}
