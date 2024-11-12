<?php

namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\Support\Traits\APIConnectionsTrait;

class InternationalBankAccount extends BankAccount
{
    use APIConnectionsTrait;

    public function __construct(float $balance)
    {
        parent::__construct($balance, "$ (USD)");
    }

    public function getConvertedBalance(): float
    {
        return $this->convertBalance($this->balance);
    }

    public function getConvertedCurrency(): string
    {
        return $this->getConvertedBalance() . $this->getCURRENCY();
    }
}
