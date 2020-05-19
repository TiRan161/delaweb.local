<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{

    public function index()
    {
        $user = $this->getUser();
        return $this->render('profile.html.twig',['user' => $user]);
    }

}