<?php
namespace Edcs\Mondo\Entitites;

use ArrayAccess;
use Psr\Http\Message\ResponseInterface;

abstract class Entity implements ArrayAccess
{
    /**
     * The response body returned from the api.
     *
     * @var array
     */
    private $body;

    /**
     * Entity constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->body = json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Whether a offset exists
     *
     * @param mixed $key
     * @return boolean
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->body);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->body[$key];
    }

    /**
     * Offset to set.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->body[] = $value;
        } else {
            $this->body[$key] = $value;
        }
    }

    /**
     * Offset to unset.
     *
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        unset($this->body[$key]);
    }
}
