<?php

require '../vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://api.getmondo.co.uk',
    'headers'  => [
        'Authorization' => 'Bearer {your-access-token}',
    ],
]);

$client = new Http\Adapter\Guzzle6\Client($client);

$ping = new Edcs\Mondo\Resources\Ping($client);

$entity = $ping->whoAmI();

?>

<h1>Who Am I?</h1>

<table>
    <thead>
        <tr>
            <th>Authenticated?</th>
            <th>Client ID</th>
            <th>User ID</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?=$entity->getAuthenticated() ? 'Yes' : 'No' ?></td>
            <td><?=$entity->getClientId() ?></td>
            <td><?=$entity->getUserId() ?></td>
        </tr>
    </tbody>
</table>

<?php

$accounts = new Edcs\Mondo\Resources\Accounts($client);

$accountCollection = $accounts->get();

?>

<h1>Accounts</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Account Number</th>
            <th>Sort Code</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accountCollection as $account) : ?>
            <tr>
                <td><?=$account->getId() ?></td>
                <td><?=$account->getDescription() ?></td>
                <td><?=$account->getAccountNumber() ?></td>
                <td><?=$account->getSortCode() ?></td>
                <td><?=$account->getCreated() ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php

$balance = new Edcs\Mondo\Resources\Balances($client);

?>

<h1>Balances</h1>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Balance</th>
        <th>Currency</th>
        <th>Spend Today</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($accountCollection as $account) : ?>
        <?php $entity = $balance->get($account->getId()) ?>
        <tr>
            <td><?=$account->getId() ?></td>
            <td><?=\Edcs\Mondo\Support\Str::money($entity->getBalance()) ?></td>
            <td><?=$entity->getCurrency() ?></td>
            <td><?=\Edcs\Mondo\Support\Str::money($entity->getSpendToday()) ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?php

$transactions = new Edcs\Mondo\Resources\Transactions($client);

$transactionCollection = $transactions->get($accountCollection[0]->getId());

?>

<h1>Transactions for Account #<?=$accountCollection[0]->getId() ?></h1>

<table>
    <thead>
    <tr>
        <th>Account Balance</th>
        <th>Amount</th>
        <th>Created</th>
        <th>Currency</th>
        <th>Description</th>
        <th>ID</th>
        <th>Merchant</th>
        <th>Metadata</th>
        <th>Notes</th>
        <th>Is Load?</th>
        <th>Settled?</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($transactionCollection as $transaction) : ?>
            <tr>
                <td><?=\Edcs\Mondo\Support\Str::money($transaction->getAccountBalance()) ?></td>
                <td><?=\Edcs\Mondo\Support\Str::money($transaction->getAmount()) ?></td>
                <td><?=$transaction->getCreated() ?></td>
                <td><?=$transaction->getCurrency() ?></td>
                <td><?=$transaction->getDescription() ?></td>
                <td><?=$transaction->getId() ?></td>
                <td><?=$transaction->getMerchant()['name'] ?></td>
                <td><?=json_encode($transaction->getMetadata()) ?></td>
                <td><?=$transaction->getNotes() ?></td>
                <td><?=$transaction->getIsLoad() ? 'Yes' : 'No' ?></td>
                <td><?=$transaction->getSettled() ?></td>
                <td><?=$transaction->getCategory() ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php

$transaction = $transactions->find($transactionCollection[0]->getId());

?>

<h1>Transaction #<?=$transaction->getId() ?></h1>

<table>
    <thead>
    <tr>
        <th>Account Balance</th>
        <th>Amount</th>
        <th>Created</th>
        <th>Currency</th>
        <th>Description</th>
        <th>ID</th>
        <th>Merchant</th>
        <th>Metadata</th>
        <th>Notes</th>
        <th>Is Load?</th>
        <th>Settled?</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td><?=\Edcs\Mondo\Support\Str::money($transaction->getAccountBalance()) ?></td>
            <td><?=\Edcs\Mondo\Support\Str::money($transaction->getAmount()) ?></td>
            <td><?=$transaction->getCreated() ?></td>
            <td><?=$transaction->getCurrency() ?></td>
            <td><?=$transaction->getDescription() ?></td>
            <td><?=$transaction->getId() ?></td>
            <td><?=$transaction->getMerchant()['name'] ?></td>
            <td><?=json_encode($transaction->getMetadata()) ?></td>
            <td><?=$transaction->getNotes() ?></td>
            <td><?=$transaction->getIsLoad() ? 'Yes' : 'No' ?></td>
            <td><?=$transaction->getSettled() ?></td>
            <td><?=$transaction->getCategory() ?></td>
        </tr>
    </tbody>
</table>

<h1>Anotate Transaction</h1>

<form action="metadata.php" method="post">
    <select name="transaction">
        <?php foreach ($transactionCollection as $transaction) : ?>
            <option value="<?=$transaction->getId() ?>">
                <?=\Edcs\Mondo\Support\Str::money($transaction->getAmount()) ?>
                at
                <?=$transaction->getMerchant()['name'] ?>
            </option>
        <?php endforeach ?>
    </select>
    <label for="key">Metadata Key</label>
    <input type="text" id="key" name="key">
    <label for="key">Metadata Value</label>
    <input type="text" id="value" name="value">
    <input type="submit" value="Save Metadata">
</form>
