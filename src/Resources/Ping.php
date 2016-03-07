<?php

namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Entitites\WhoAmI;
use GuzzleHttp\Psr7\Request;

class Ping extends Resource
{
    /**
     * Returns information about the current access token.
     *
     * @link https://getmondo.co.uk/docs/#authenticating-requests
     *
     * @return WhoAmI
     */
    public function whoAmI()
    {
        $request = new Request('get', '/ping/whoami');
        $response = $this->sendRequest($request);

        return new WhoAmI($response);
    }
}
