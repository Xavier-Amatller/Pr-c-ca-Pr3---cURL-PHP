<?php

namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\Support\Traits\APIConnectionsTrait;

class InternationalBankAccount extends BankAccount
{
    use APIConnectionsTrait;

    public function __construct(float $balance)
    {
        parent::__construct($balance, "$");
    }

    public function getConvertedBalance(): float
    {
        pl("hoala");
        // return 0;
        return $this->convertBalance($this->balance);
    }

    public function getConvertedCurrency(): string
    {
        return $this->getConvertedBalance() . $this->getCURRENCY();
    }
}
