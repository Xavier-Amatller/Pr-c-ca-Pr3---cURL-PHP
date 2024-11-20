<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Person\Person;
use Combank\Support\Traits\APIConnectionsTrait;


require_once 'bootstrap.php';

//---[Start testing national account]---/

$nationalAccount = new NationalBankAccount(100);

pl("My balance: " . $nationalAccount->getBalance() . $nationalAccount->getCURRENCY());
 
//---[Start testing international account (dollar conversion)]---/

$internationalAccount = new InternationalBankAccount(100);

pl("My balance: " . $internationalAccount->getBalance() . $internationalAccount->getCURRENCY());

pl("Converted balance: " . $internationalAccount->getConvertedCurrency());

//---[Start testing national account (email validation)]---/

try {
    $email = "john.doe@example.com";
    pl("Validating email: " . "$email");
    new Person("john", 1, $email);
    pl("Email is valid");
} catch (InvalidArgumentException $e) {
    pl($e->getMessage());
}
//---[Start testing international account (email validation)]---/

try {
    $email = "jane.dow@invalid-email";
    pl("Validating email: " . "$email");
    new Person("jane", 2, $email);
    pl("Email is valid");
} catch (InvalidArgumentException $e) {
    pl($e->getMessage());
}

//---[Start testing Fraud]---/


try{
    $testFraud = new $internationalAccount(5000000);
    $testFraud->transaction(new DepositTransaction(10000));

}catch(Exception $exception){
    pl($exception->getMessage());
}