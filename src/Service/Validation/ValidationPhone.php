<?php


namespace App\Service\Validation;


class ValidationPhone extends AbstractValidation
{

    protected function validate()
    {
        $value = $this->value;

        if (empty($this->value)) {
            return $this->message = 'Отсутствует номер телефона пользователя';
        }

        if (!is_string($value)) {
            return $this->message = 'Телефон Not valid type';
        }

        if (strlen($value) < 6 || strlen($value) > 15  ) {
            return $this->message = 'Длина номера не соответствует заданному диапазону 6-15';
        }

        return $this->isValid = true;
    }
}