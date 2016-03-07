<?php

namespace Edcs\Mondo\Resources;

use Edcs\Mondo\Entitites\Collection;
use Edcs\Mondo\Entitites\Transaction;
use GuzzleHttp\Psr7\Request;

class Transactions extends Resource
{
    /**
     * Returns a list of transactions for the supplied account.
     *
     * @link https://getmondo.co.uk/docs/#list-transactions
     *
     * @param string $accountId
     * @param bool   $expandMerchant
     *
     * @return Collection
     */
    public function get($accountId, $expandMerchant = true)
    {
        $query = ['account_id' => $accountId];

        if ($expandMerchant) {
            $query += ['expand[]' => 'merchant'];
        }

        $query = \GuzzleHttp\Psr7\build_query($query);

        $request = new Request('get', "/transactions?{$query}");
        $response = $this->sendRequest($request);

        return new Collection($response, 'transactions', Transaction::class);
    }

    /**
     * Returns the specified transaction.
     *
     * @link https://getmondo.co.uk/docs/#list-transactions
     *
     * @param string $transactionId
     * @param bool   $expandMerchant
     *
     * @return Transaction
     */
    public function find($transactionId, $expandMerchant = true)
    {
        $query = [];

        if ($expandMerchant) {
            $query += ['expand[]' => 'merchant'];
        }

        $query = \GuzzleHttp\Psr7\build_query($query);

        $request = new Request('get', "/transactions/{$transactionId}?{$query}");

        $response = $this->sendRequest($request);
        $response = json_decode($response->getBody()->getContents(), true);

        return new Transaction($response['transaction']);
    }

    /**
     * Adds annotation metadata to a transaction.
     *
     * @link https://getmondo.co.uk/docs/#annotate-transaction
     *
     * @param string $transactionId
     * @param array  $metadata
     * @param bool   $expandMerchant
     *
     * @return Transaction
     */
    public function annotate($transactionId, array $metadata, $expandMerchant = true)
    {
        $query = [];

        if ($expandMerchant) {
            $query += ['expand[]' => 'merchant'];
        }

        $query = \GuzzleHttp\Psr7\build_query($query);

        $request = new Request(
            'patch',
            "/transactions/{$transactionId}?{$query}",
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            $this->parseParameters($metadata, 'metadata')
        );

        $response = $this->sendRequest($request);
        $response = json_decode($response->getBody()->getContents(), true);

        return new Transaction($response['transaction']);
    }
}
