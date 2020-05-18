<?php


namespace App\Service\Validation;


class ValidationOrganisation extends AbstractValidation
{

    protected function validate()
    {
        if (empty($this->value)) {
            return $this->message = 'Отсутствует название организации пользователя';
        }

        if (!is_string($this->value)) {
            return $this->message = 'Организация Not valid type';
        }

        return $this->isValid = 'true';
    }
}