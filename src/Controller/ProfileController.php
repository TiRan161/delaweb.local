<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        /** @var User $user */
        $user = $this->getUser();
        $users = $this->userService->getUsersNotEqual($user);


        //

        return $this->render('profile.html.twig', ['user' => $user, 'users' => $users]);
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $postData = $request->request->all();
        $result = $this->userService->updateUser($user, $postData);

        return new JsonResponse($result);

    }

}