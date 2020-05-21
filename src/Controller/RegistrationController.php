<?php


namespace App\Controller;


use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{

    private $userService;

    private $authenticator;

    public function __construct(UserService $userService, LoginFormAuthenticator $authenticator)
    {
        $this->userService = $userService;
        $this->authenticator = $authenticator;
    }

    public function index()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        }
        $users = $this->userService->getUsers();
        return $this->render('registration.html.twig', ['users' => $users]);
    }

    public function createUser(Request $request, GuardAuthenticatorHandler $authenticatorHandler)
    {
        $data = $request->request->all();
        $result = $this->userService->createUser($data);
        if ($result['status']) {
            /** @var UserInterface $user */
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['phone' => $data['phone']]);
            $authenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $this->authenticator, 'main');
        }

        return new JsonResponse($result);

    }

}