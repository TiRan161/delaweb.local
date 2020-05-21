<?php


namespace App\Controller;


use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('profile');
        }

        $users = $this->userService->getUsers();

        return $this->render('registration.html.twig', ['users' => $users]);
    }

    public function createUser(Request $request)
    {


        $data = $request->request->all();
        $result = $this->userService->createUser($data);
        return new JsonResponse($result);

    }

}