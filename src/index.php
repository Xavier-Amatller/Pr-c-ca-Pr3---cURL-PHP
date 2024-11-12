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

$email = "joe.doe@example.com";
pl("Validation email: " . $email);

class a
{
    use APIConnectionsTrait;
}
$a = new a();
pl("Email is: " . ($a->validateEmail($email) ? "valid" : "invalid"));


//---[Start testing international account (email validation)]---/

