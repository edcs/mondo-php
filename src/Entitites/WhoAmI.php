<?php

namespace Edcs\Mondo\Entitites;

/**
 * An onject describing the access token used for an api request.
 *
 * @link https://getmondo.co.uk/docs/#authenticating-requests
 *
 * @method bool getAuthenticated() Whether or not the access token is authenticated.
 * @method string getClientId() Getter for the client id for the access token.
 * @method string getUserId() Getter for the id of the user associated with the access token.
 */
class WhoAmI extends Entity
{
    //
}
