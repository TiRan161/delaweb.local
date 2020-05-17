<?php


namespace App\Service;


use App\Entity\Organisation;
use App\Entity\User;
use App\Service\Validation\ValidationName;
use App\Service\Validation\ValidationPhone;
use App\Service\Validation\ValidationSurname;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getUsers(): array
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    public function registration(array $data): array
    {
        $result = [
            'status' => true,
            'message' => ''
        ];

        $isValidName = new ValidationName($data['name']);
        if (!$isValidName->isValid()) {
            $result['message'] = $isValidName->getMessage();
            $result['status'] = false;
            return $result;
        }

        $isValidSurname = new ValidationSurname($data['surname']);
        if (!$isValidSurname->isValid()) {
            $result['message'] = $isValidSurname->getMessage();
            $result['status'] = false;
            return $result;
        }

        $isValidPhone = new ValidationPhone($data['phone']);
        if (!$isValidPhone->isValid()) {
            $result['message'] = $isValidPhone->getMessage();
            $result['status'] = false;
            return $result;
        }

        if (empty($data['invited'])) {
            $result['status'] = false;
            $result['message'] = 'Отсутствует идентификатор пользователя который пригласил';
            return $result;
        }

        $invited = $this->em->find(User::class, $data['invited']);

        if ($invited === null) {
            $result['status'] = false;
            $result['message'] = 'Отсутствует пользователь который пригласил';
            return $result;
        }

//        if (empty($data['name'])) {
//            $result['status'] = false;
//            $result['message'] = 'Отсутствует имя пользователя';
//            return $result;
//        }

        if (empty($data['organisation'])) {
            $result['status'] = false;
            $result['message'] = 'Отсутствует пользователь который пригласил';
            return $result;
        }

        if (empty($data['password'])) {
            $result['status'] = false;
            $result['message'] = 'Отсутствует пароль';
            return $result;
        }

        if (empty($data['confirmed-password'])) {
            $result['status'] = false;
            $result['message'] = 'Отсутствет подтверждение пароля';
            return $result;
        }

        if ($data['password'] !== $data['confirmed-password']) {
            $result['status'] = false;
            $result['message'] = 'Пароли не совпадают';
            return $result;
        }

//        if (empty($data['phone'])) {
//            $result['status'] = false;
//            $result['message'] = 'Отсутствует номер телефона';
//        }
//
//        if (empty($data['surname'])) {
//            $result['status'] = false;
//            $result['message'] = 'Отсутствует фамилия пользователя';
//        }


        $organisation = $this
            ->em
            ->getRepository(Organisation::class)
            ->findOneBy(['id' => $data['organisation']]);


        $newUser = (new User())
            ->setInvited($invited)
            ->setName($data['name'])
            ->setOrganisation($organisation)
            ->setPassword($data['password'])
            ->setPhone($data['phone'])
            ->setSurname($data['surname']);

        return $result;
    }

}