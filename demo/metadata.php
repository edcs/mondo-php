<?php

require '../vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://api.getmondo.co.uk',
    'headers'  => [
        'Authorization' => 'Bearer {your-access-token}',
    ],
]);

$client = new Http\Adapter\Guzzle6\Client($client);

$transactions = new Edcs\Mondo\Resources\Transactions($client);

$transacion = $transactions->annotate($_POST['transaction'], [$_POST['key'] => $_POST['value']]);

header('Location: /');
