<?php

namespace OpenXPort\Jmap\Mail;

use JsonSerializable;

class EmailAddress implements JsonSerializable
{
    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "name" => $this->getName(),
            "email" => $this->getEmail()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
