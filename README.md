# Mondo PHP

[![Codeship Status for edcs/mondo-php](https://codeship.com/projects/2436c2a0-c5a4-0133-0473-425c22e45b5d/status?branch=master)](https://codeship.com/projects/138563)
[![Coverage Status](https://coveralls.io/repos/github/edcs/mondo-php/badge.svg?branch=master)](https://coveralls.io/github/edcs/mondo-php?branch=master)
[![StyleCI](https://styleci.io/repos/52679537/shield)](https://styleci.io/repos/52679537)

This package is a [PHP-HTTP](http://docs.php-http.org/en/latest/index.html) and [PSR-7](http://www.php-fig.org/psr/psr-7/)
compatible client for accessing the Mondo API in your PHP projects.

## Installation

You can install this project using Composer. Though you'll need to choose your PHP-HTTP client before you can install 
this package. To find out more about PHP-HTTP, you can read the documentation [here](http://docs.php-http.org/en/latest/httplug/users.html).

This package has been extensively tested using Guzzle 6, if you're not already using a HTTP client in your project then
you can go ahead and use Guzzle with the following commands:

```bash
composer require php-http/guzzle6-adapter
composer require edcs/mondo-php
```

If you're already using a different HTTP client in your project, you can check and see if there's already a PHP-HTTP
adatapter available for it [here](http://docs.php-http.org/en/latest/clients.html).

## Getting an Access Token

If you'd like an easy method to create access tokens, you can use [this](https://github.com/edcs/oauth-mondo)
provider for the [Legue OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Getting Started

To instantiate a new resource first you will need to create an instance of your PHP-HTTP client, this example uses
Guzzle 6. If you are using Guzzle you will also need to inject the instance of the client into the PHP-HTTP client
factory before it can be used in one of this packages resource classes:

```php
$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://api.getmondo.co.uk',
    'headers'  => [
        'Authorization' => 'Bearer {your-access-token}',
    ],
]);

$client = new Http\Adapter\Guzzle6\Client($client);

$ping = new Edcs\Mondo\Resources\Ping($client);
```

### Ping Resource

This resource contains the following methods:

 * `whoAmI()` - Returns a `WhoAmI` entity instance which describes the current access token.
 
```php
$ping = new Edcs\Mondo\Resources\Ping($client);

$entity = $ping->whoAmI();

$entity->getAuthenticated() // true/false depending on if the current access token is authenticated.
$entity->getClientId() // A string containing the client id associated with the current access token.
$entity->getUserId() // A string containing the id of the user associated with the current access token.
```

### Accounts Resource

This resource contains the following methods:

 * `get()` - Returns a `Collection` of `Account` entities which describe the current user's Mondo accounts.
 
```php
$accounts = new Edcs\Mondo\Resources\Accounts($client);

$collection = $accounts->get()

foreach ($collection as $account) {
    $account->getId(); // A string containing the id of the account.
    $account->getDescription(); // A string containing the account description.
    $account->getAccountNumber(); // A string containing the account number.
    $account->getSortCode(); // A string containing the account sort code.
    $account->getCreated(); // A string containing the date when the account was created.
}
```

### Balance Resource

This resource contains the following methods:

 * `find($accountId)` - Returns a `Balance` entity instance which describes the account balance of the supplied account.

```php
$accountId = 'acc_00009237aqC8c5umZmrRdh';

$accounts = new Edcs\Mondo\Resources\Accounts($client);

$entity = $accounts->find($accountId);

$entity->getBalance(); // Returns the account balance in pence.
$entity->getCurrency(); // Returns the ISO currency code for this account.
$entity->getSpendToday(); // Returns the amount spent today in pence for this account.
```

### Transactions Resource

This resource contains the following methods:

 * `get($accountId)` - Returns a `Collection` of `Transaction` entities which describe the transactions on the supplied 
 account.
 * `find($transactionId)` - Returns a `Transaction` entity instance which describe the supplied transaction.
 * `annotate($transactionId, $annotation)` - Creates a new annotation and a `Transaction` entity instance which describe 
 the supplied transaction.
 
```php
$accountId = 'acc_00009237aqC8c5umZmrRdh';

$transactions = new Edcs\Mondo\Resources\Transactions($client);

$collection = $transactions->get($accountId);

foreach ($collection as $entity) {
    $entity->getAccountBalance(); // Returns the account balance in pence after this transaction.
    $entity->getAmount(); // Returns the transaction amount in pence.
    $entity->getCreated(); // Returns a string containing the date of this transaction.
    $entity->getId(); // Returns a string containing the transaction id.
    $entity->getMerchant(); // Returns an array containing information about the merchant.
    $entity->getMetadata(); // Returns an array contianing any metadata associated with this transaction.
    $entity->getNotes(); // Returns notes which describe this tranaction.
    $entity->getIsLoad(); // Returns true if this transation is a top-up, otherwise returns false.
    $entity->getSettled(); // Returns a string containing the date this transaction was settled.
    $entity->getCategory(); // Returns the category which this transaction belongs to.
}

$transactionId = 'tx_00008zIcpb1TB4yeIFXMzx';

$entity = $this->find($transactionId); // Entity methods described above.

$metadata = [
    'metadata_key' => 'This is a metadata description.'
];

$entity = $this->annotate($transactionId , $metadata); // Entity methods described above.
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/edcs/mondo-php/blob/master/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Edward Coleridge Smith at 
edcoleridgesmith@gmail.com. All security vulnerabilities will be promptly addressed.

## License

The MIT License (MIT). Please see [License File](https://github.com/edcs/mondo-php/blob/master/LICENSE.md) for 
more information.
