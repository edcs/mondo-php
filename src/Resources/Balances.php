<?php

namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Entitites\Balance;
use GuzzleHttp\Psr7\Request;

class Balances extends Resource
{
    /**
     * Returns the balance of the supplied account.
     *
     * @link https://getmondo.co.uk/docs/#balance
     *
     * @param string $id
     *
     * @return Balance
     */
    public function get($id)
    {
        $query = \GuzzleHttp\Psr7\build_query(['account_id' => $id]);

        $request = new Request('get', "/balance?{$query}");
        $response = $this->sendRequest($request);

        return new Balance($response);
    }
}
