<?php

namespace ComBank\History;

use ComBank\Transactions\Contracts\BankTransactionInterface;

/**
 * Created by VS Code.
 * User: XavierAmatller
 * Date: 10/18/24
 * Time: 18:51 PM
 */

class TransactionHistory
{

    private $transactions = [];

    public function addTransaction(BankTransactionInterface $transaction)
    {

        $transactionTipe = $transaction->getTransactionInfo();
        $transactionAmount = $transaction->getAmount();

        $date = new \DateTime();

        array_push($this->transactions, [
            "type" => $transactionTipe,
            "amount" => $transactionAmount,
            "dateTime" => $date->format('Y-m-d H:i:s')
        ]);
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
