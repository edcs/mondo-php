<?php

namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Exceptions\HttpException;
use Exception;
use GuzzleHttp\Psr7\MultipartStream;
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

        return $response;
    }

    /**
     * Converts an array of parameters into a multipart stream which can be used in an api request.
     *
     * @param array $parameters
     * @param $name
     * @return MultipartStream
     */
    protected function parseParameters(array $parameters, $name)
    {
        $parsed = [];

        foreach ($parameters as $key => $value) {
            $parsed["{$name}[{$key}]"] = $value;
        }

        return \GuzzleHttp\Psr7\build_query($parsed, false);
    }
}
