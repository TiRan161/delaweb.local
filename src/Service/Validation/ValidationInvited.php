<?php


namespace App\Service\Validation;


class ValidationInvited extends AbstractValidation
{

    protected function validate()
    {
        if (empty($this->value)) {
            return $this->message = 'Отсутствует пользователь который приграсил';
        }

        return $this->isValid = true;
    }
}