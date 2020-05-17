<?php


namespace App\Service\Validation;


class ValidationPhone extends AbstractValidation
{

    protected function validate()
    {
        $value = $this->value;

        if (empty($this->value)) {
            $this->message = 'Отсутствует номер телефона пользователя';
        }

        if (!is_string($value)) {
            $this->message = 'Not valid type';
        }

        if (strlen($value) < 6 || strlen($value) > 15  ) {
            $this->message = 'Длина номера не соответствует заданному диапазону 6-15';
        }
    }
}