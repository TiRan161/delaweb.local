<?php


namespace App\Service\Validation;


abstract class AbstractValidation
{
    protected $value;
    /** @var boolean */
    protected $isValid;
    protected $message;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->isValid = false;
        $this->validate();
    }

    abstract protected function validate();

    public function getMessage()
    {
        return $this->message;
    }

    public function isValid()
    {
        return $this->isValid;
    }

}