<?php
namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Entitites\Ping\WhoAmI;
use GuzzleHttp\Psr7\Request;

class Ping extends Resource
{
    /**
     * Returns information about the current access token.
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
