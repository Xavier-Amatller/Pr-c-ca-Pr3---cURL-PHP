<?php

namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait APIConnectionsTrait
{
    public function validateEmail(string $email): bool {
        return false;
    }

    public function convertBalance(float $balance): float {
        return 1.1;


    }

    public function detectFraud(BankTransactionInterface $transaction): bool {
        return false;
    }
}
