<?php

namespace Edcs\Mondo\Entitites;

use ArrayAccess;
use Edcs\Mondo\Exceptions\InvalidEntity;
use Iterator;
use Psr\Http\Message\ResponseInterface;

class Collection implements ArrayAccess, Iterator
{
    /**
     * The response body returned from the api.
     *
     * @var array
     */
    private $body;

    /**
     * The name of the entity which should be returned.
     *
     * @var string
     */
    private $entity;

    /**
     * The current itteration position.
     *
     * @var int
     */
    private $position = 0;

    /**
     * Collection constructor.
     *
     * @param ResponseInterface $response
     * @param string            $namespace
     * @param string            $entity
     */
    public function __construct(ResponseInterface $response, $namespace, $entity)
    {
        $contents = json_decode($response->getBody()->getContents(), true);

        $this->body = $contents[$namespace];
        $this->entity = $entity;
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
        if (is_array($this->body[$key])) {
            $this->body[$key] = new $this->entity($this->body[$key]);
        }

        return $this->body[$key];
    }

    /**
     * Offset to set.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws InvalidEntity
     */
    public function offsetSet($key, $value)
    {
        if (!is_array($value) && !is_subclass_of($value, Entity::class)) {
            throw new InvalidEntity('Value should either be type array or an instance of '.Entity::class);
        }

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

    /**
     * Return the current element.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->offsetGet($this->position);
    }

    /**
     * Move forward to next element.
     *
     * @return void
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Return the key of the current element.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->offsetExists($this->position);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
