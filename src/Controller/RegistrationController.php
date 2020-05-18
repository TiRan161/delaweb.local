<?php


namespace App\Controller;


use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
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
        $users = $this->userService->getUsers();
        var_dump($users);

        return $this->render('registration.html.twig', ['users' => $users]);
    }

    public function createUser(Request $request)
    {

        $data = $request->request->all();
        $result = $this->userService->createUser($data);
        var_dump($result);
        die();
//        //$data = json_decode($request->getContent());

//        $response = new JsonResponse($result);
//        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
//
//        return $response;

    }

}