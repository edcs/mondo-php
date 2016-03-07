<?php

namespace Edcs\Mondo\Test\Resources;

use Edcs\Mondo\Entitites\Transaction;
use Edcs\Mondo\Resources\Transactions;
use Edcs\Mondo\Test\TestCase;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use Mockery as m;

class TransactionsTest extends TestCase
{
    /**
     * Creates a fake json transaction response.
     *
     * @return array
     */
    private function createResponse()
    {
        return [
            'transactions' => [
                [
                    'account_balance' => uniqid(),
                    'amount'          => uniqid(),
                    'created'         => uniqid(),
                    'currency'        => uniqid(),
                    'description'     => uniqid(),
                    'id'              => uniqid(),
                    'merchant'        => uniqid(),
                    'metadata'        => [],
                    'notes'           => uniqid(),
                    'is_load'         => rand(0, 1),
                    'settled'         => rand(0, 1),
                    'category'        => uniqid(),
                ],
            ],
        ];
    }

    /**
     * Ensures that a collection of transaction entities are returned by the get transactions resource.
     */
    public function testTransactionsGet()
    {
        $json = $this->createResponse();

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andReturn(new Response(200, [], json_encode($json)));

        $transactions = new Transactions($client);

        $collection = $transactions->get(uniqid());

        /** @var Transaction $account */
        foreach ($collection as $key => $account) {
            $this->assertEquals($json['transactions'][$key]['account_balance'], $account->getAccountBalance());
            $this->assertEquals($json['transactions'][$key]['amount'], $account->getAmount());
            $this->assertEquals($json['transactions'][$key]['created'], $account->getCreated());
            $this->assertEquals($json['transactions'][$key]['currency'], $account->getCurrency());
            $this->assertEquals($json['transactions'][$key]['description'], $account->getDescription());
            $this->assertEquals($json['transactions'][$key]['id'], $account->getId());
            $this->assertEquals($json['transactions'][$key]['merchant'], $account->getMerchant());
            $this->assertEquals($json['transactions'][$key]['metadata'], $account->getMetadata());
            $this->assertEquals($json['transactions'][$key]['notes'], $account->getNotes());
            $this->assertEquals($json['transactions'][$key]['is_load'], $account->getIsLoad());
            $this->assertEquals($json['transactions'][$key]['category'], $account->getCategory());
            $this->assertEquals($json['transactions'][$key]['settled'], $account->getSettled());
            $this->assertEquals(null, $account->getDeclineReason());
        }
    }

    /**
     * Ensures that a declined transaction can return it's decline reason.
     */
    public function testDeclinedTransactionsGet()
    {
        $json = $this->createResponse();
        $json['transactions'][0]['decline_reason'] = 'INSUFFICIENT_FUNDS';

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andReturn(new Response(200, [], json_encode($json)));

        $transactions = new Transactions($client);

        $collection = $transactions->get(uniqid());

        /** @var Transaction $account */
        foreach ($collection as $key => $account) {
            $this->assertEquals($json['transactions'][$key]['decline_reason'], $account->getDeclineReason());
        }
    }

    /**
     * Ensures that a single transaction can be returned via the find method.
     */
    public function testTransactionsFind()
    {
        $response = $this->createResponse();

        $json = ['transaction' => $response['transactions'][0]];

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andReturn(new Response(200, [], json_encode($json)));

        $transactions = new Transactions($client);

        $transaction = $transactions->find(uniqid());

        $this->assertEquals($json['transaction']['account_balance'], $transaction->getAccountBalance());
        $this->assertEquals($json['transaction']['amount'], $transaction->getAmount());
        $this->assertEquals($json['transaction']['created'], $transaction->getCreated());
        $this->assertEquals($json['transaction']['currency'], $transaction->getCurrency());
        $this->assertEquals($json['transaction']['description'], $transaction->getDescription());
        $this->assertEquals($json['transaction']['id'], $transaction->getId());
        $this->assertEquals($json['transaction']['merchant'], $transaction->getMerchant());
        $this->assertEquals($json['transaction']['metadata'], $transaction->getMetadata());
        $this->assertEquals($json['transaction']['notes'], $transaction->getNotes());
        $this->assertEquals($json['transaction']['is_load'], $transaction->getIsLoad());
        $this->assertEquals($json['transaction']['category'], $transaction->getCategory());
        $this->assertEquals($json['transaction']['settled'], $transaction->getSettled());
        $this->assertEquals(null, $transaction->getDeclineReason());
    }

    /**
     * Ensures that a transaction can be anotated.
     */
    public function testTransactionsAnotate()
    {
        $response = $this->createResponse();

        $json = ['transaction' => $response['transactions'][0]];

        $client = m::mock(Client::class);

        $client->shouldReceive('sendRequest')
               ->once()
               ->andReturn(new Response(200, [], json_encode($json)));

        $transactions = new Transactions($client);

        $transactions->annotate(uniqid(), ['foo' => 'bar']);
    }
}
