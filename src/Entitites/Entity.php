<?php

namespace Edcs\Mondo\Entitites;

use ArrayAccess;
use Edcs\Mondo\Exceptions\MethodDoesNotExist;
use Edcs\Mondo\Support\Str;
use InvalidArgumentException;
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
     * @param array|ResponseInterface $response
     */
    public function __construct($response)
    {
        if (is_array($response)) {
            $this->body = $response;
        } elseif ($response instanceof ResponseInterface) {
            $this->body = json_decode($response->getBody()->getContents(), true);
        } else {
            throw new InvalidArgumentException(
                'Entities can only be constructed with arrays or instances of '.ResponseInterface::class
            );
        }
    }

    /**
     * Call method used to create getters for individual entity classes.
     *
     * @param string $name
     * @param array $arguments
     * @return string
     * @throws MethodDoesNotExist
     */
    public function __call($name, $arguments)
    {
        $key = Str::camelToSnake(substr($name, 3));

        if ($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }

        throw new MethodDoesNotExist('The method '.$name.' does not exist in '.get_class($this));
    }

    /**
     * Whether a offset exists.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->body);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $key
     *
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
