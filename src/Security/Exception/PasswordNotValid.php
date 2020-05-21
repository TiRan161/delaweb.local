<?php


namespace App\Security\Exception;


use Symfony\Component\Security\Core\Exception\AuthenticationException;

class PasswordNotValid extends AuthenticationException
{
    public function getMessageKey()
    {
        return 'Некорректный пароль';
    }

}