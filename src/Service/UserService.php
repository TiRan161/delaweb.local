<?php


namespace App\Service;


use App\Entity\Organisation;
use App\Entity\User;
use App\Service\Validation\ValidationInvited;
use App\Service\Validation\ValidationName;
use App\Service\Validation\ValidationOrganisation;
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

    public function createUser(array $data): array
    {
        $result = $this->validation($data);

        if (!$result['status']) {
            return $result;
        }

        $organisation = $this->getOrganisationByName($data['organisation']);
        if ($organisation === null) {
            $result['status'] = false;
            $result['message'] = 'Не удалось создать запись Организация';
        }
        /** @var User $invited */
        $invited = $this->em->find(User::class, $data['invited']);

        if ($invited === null) {
            $result['status'] = false;
            $result['message'] = 'Отсутствует пользователь который пригласил';
            return $result;
        }

//
//        Необходима доработка
//

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

//
//
//


        $newUser = (new User())
            ->setInvited($invited)
            ->setName($data['name'])
            ->setOrganisation($organisation)
            ->setPassword($data['password'])
            ->setPhone($data['phone'])
            ->setSurname($data['surname']);
        $this->em->persist($newUser);
        $this->em->flush();


        return $result;
    }

    private function getOrganisationByName(string $name): Organisation
    {
        $organisation = $this->em->getRepository(Organisation::class)->findOneBy(['name' => $name]);

        if ($organisation === null) {
            $organisation = (new Organisation())
                ->setName($name);

            $this->em->persist($organisation);
            $this->em->flush();
        }

        return $organisation;
    }

    private function validation(array $data): array
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

        $isValidInvited = new ValidationInvited($data['invited']);
        if (!$isValidInvited->isValid()) {
            $result['message'] = $isValidInvited->getMessage();
            $result['status'] = false;
            return $result;
        }

        $isValidOrganisation = new ValidationOrganisation($data['organisation']);
        if (!$isValidOrganisation->isValid()) {
            $result['message'] = $isValidOrganisation->getMessage();
            $result['status'] = false;
            return $result;
        }

        return $result;
    }

}