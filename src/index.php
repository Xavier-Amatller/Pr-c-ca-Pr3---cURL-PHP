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


try {
    $testFraud = new $internationalAccount(5000000);
    $testFraud->transaction(new DepositTransaction(10001));
} catch (Exception $exception) {
    pl($exception->getMessage());
}



//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {

    $bankAccount2 = new BankAccount(100.0);
    $bankAccount2->applyOverdraft(new SilverOverdraft());
    // show balance account
    pl('My Balance: ' . $bankAccount2->getBalance());

    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120));
} catch (InvalidArgumentException $e) {
    pl('' . $e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
    pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());
} catch (ZeroAmountException $e) {
    pl('' . $e->getMessage());
}

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20));
    pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());
} catch (InvalidArgumentException $e) {
    pl('' . $e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
    pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());
} catch (ZeroAmountException $e) {
    pl('' . $e->getMessage());
}

showTransactionHistory($bankAccount2);


function showTransactionHistory($bankAccount)
{
    pl("******TRANSACTION HISTORY******");
    foreach ($bankAccount->getTransactionHistory()->getTransactions() as $transaction) {
        pl("Type : " . $transaction["type"]);
        pl("Amount : " . $transaction["amount"]);
        pl("DateTime : " . $transaction["dateTime"] . "<br>");
    }
    pl("******************************");
}

// Crear una nueva cuenta bancaria
$cuenta = new BankAccount(1, '€ (EUR)');

// Añadir transacciones al histórico
$cuenta->getTransactionHistory()->addTransaction(new DepositTransaction(500));
$cuenta->getTransactionHistory()->addTransaction(new WithdrawTransaction(150)); 

// Validar el préstamo usando el trait
$resultado = $cuenta->validarPrestamo($cuenta, 300);

// Imprimir el resultado
if ($resultado['success']) {
    echo "Préstamo aprobado: " . $resultado['message'] . "\n";
    echo "Tasa de interés: " . $resultado['interestRate'] . "%\n";
    echo "Pago mensual: " . $resultado['monthlyPayment'] . "€\n";
} else {
    echo "Préstamo no aprobado: " . $resultado['message'] . "\n";
}