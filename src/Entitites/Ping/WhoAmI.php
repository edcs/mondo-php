<?php
namespace Edcs\Mondo\Entitites\Ping;

use Edcs\Mondo\Entitites\Entity;

class WhoAmI extends Entity
{
    /**
     * Returns true if the access token is authenticated, otherwise returns false.
     *
     * @return boolean
     */
    public function authenticated()
    {
        return $this->offsetGet('authenticated');
    }

    /**
     * Returns the client id.
     *
     * @return string
     */
    public function clientId()
    {
        return $this->offsetGet('client_id');
    }

    /**
     * Returns the id of the user who owns this access token.
     *
     * @return string
     */
    public function userId()
    {
        return $this->offsetGet('user_id');
    }
}
