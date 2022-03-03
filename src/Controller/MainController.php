<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/about-me", name="about_me")
     */
    public function aboutUs(): Response
    {
        return $this->render('main/about-me.html.twig', [
            'titre' => 'About me',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function index(WishRepository $repo): Response
    {
        return $this->render('main/index.html.twig', [
            'list' => $repo->findAll()
        ]);
    }

   
}
