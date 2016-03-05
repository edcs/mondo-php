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
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->body);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->body[$offset];
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->body[$offset] = $value;
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->body[$offset]);
    }
}
