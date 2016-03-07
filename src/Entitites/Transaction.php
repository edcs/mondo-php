<?php

namespace Edcs\Mondo\Entitites;

/**
 * An object descibing a transaction.
 *
 * @link https://getmondo.co.uk/docs/#transactions
 *
 * @method int getAccountBalance() Getter for the the account balance after the transaction - returns the balance in pence.
 * @method int getAmount() Getter for the the transaction amount - returns the balance in pence.
 * @method string getCreated() Getter for the transaction created date.
 * @method string getCurrency() Getter for the transaction ISO currency code.
 * @method string getDescription() Getter for the transaction description.
 * @method string getId() Getter for the transaction id.
 * @method array getMerchant() Getter for the merchant information array.
 * @method array getMetadata() Getter for any metadata associated with this transaction.
 * @method array getNotes() Getter for any notes associated with this transaction.
 * @method array getCategory() Getter for the category of this transaction.
 * @method bool getIsLoad() Getter for the is load property of the transaction.
 * @method bool|string getSettled() Getter for the settled property - returns boolean or the dat when the transaction was settled.
 */
class Transaction extends Entity
{
    /**
     * Getter for the decline reason property - needs to be explicitly defined because this property is not always
     * present in the response object.
     *
     * @return string|null
     */
    public function getDeclineReason()
    {
        if ($this->offsetExists('decline_reason')) {
            return $this->offsetGet('decline_reason');
        }
    }
}
