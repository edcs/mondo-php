<?php

namespace Edcs\Mondo\Entitites;

/**
 * An object descibing a mondo bank account.
 *
 * @link https://getmondo.co.uk/docs/#balance
 *
 * @method int getBalance() Getter for the account balance - returns the balance in pence.
 * @method string getCurrency() Getter for the account ISO currency code.
 * @method int getSpendToday() Getter for the spend today amount - returns the value in pence.
 */
class Balance extends Entity
{
    //
}
