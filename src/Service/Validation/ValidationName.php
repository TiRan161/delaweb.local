<?php


namespace App\Service\Validation;


class ValidationName extends AbstractValidation
{
    protected function validate()
    {
        if (empty($this->value)) {
            return $this->message = 'Отсутствует имя пользователя';
        }

        if (is_string($this->value)) {
            $this->message = 'Not valid type';
        }

        if (!(preg_match("/^[а-яА-ЯёЁa-zA-Z]+$/",$this->value))) {
            return $this->message = 'Имя содержит неподходящие символы';
        }

        return $this->isValid = true;
    }
}