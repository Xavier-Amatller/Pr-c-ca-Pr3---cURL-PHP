<?php

namespace ComBank\Person;

use Combank\Support\Traits\APIConnectionsTrait;

class Person
{
    use APIConnectionsTrait;

    public string $name;
    public int $IDCARD;
    public string $email;


    public function __construct(string $name, int $IDCARD, string $email)
    {
        $this->$name = $name;

        $this->IDCARD = $IDCARD;

        $this->email = $email;
    }


    /**
     * Get the value of IDCARD
     */
    public function getIDCARD()
    {
        return $this->IDCARD;
    }

    /**
     * Set the value of IDCARD
     *
     * @return  self
     */
    public function setIDCARD($IDCARD)
    {
        $this->IDCARD = $IDCARD;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
