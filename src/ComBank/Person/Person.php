<?php

namespace ComBank\Person;

use ComBank\Bank\Contracts\BackAccountInterface;

class Person
{
    public string $DNI;
    public string $EMAIL;

    /**
     * @var BackAccountInterface[]
     */
    public array $bankAccounts;

    public function __construct(string $EMAIL)
    {
        $this->DNI = "";
        $this->EMAIL = $EMAIL;
        $this->bankAccounts = [];
    }


    /**
     * Get the value of DNI
     */
    public function getDNI()
    {
        return $this->DNI;
    }

    /**
     * Set the value of DNI
     *
     * @return  self
     */
    public function setDNI($DNI)
    {
        $this->DNI = $DNI;

        return $this;
    }

    /**
     * Get the value of EMAIL
     */
    public function getEMAIL()
    {
        return $this->EMAIL;
    }

    /**
     * Set the value of EMAIL
     *
     * @return  self
     */
    public function setEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;

        return $this;
    }

    /**
     * Get the value of bankAccounts
     */
    public function getBankAccounts()
    {
        return $this->bankAccounts;
    }

    /**
     * Set the value of bankAccounts
     *
     * @return  self
     */
    public function addBankAccount(BackAccountInterface $bankAccount)
    {
        // array_push($this->bankAccounts, $bankAccount);
        $this->bankAccounts[] = $bankAccount;
        return $this;
    }
}
