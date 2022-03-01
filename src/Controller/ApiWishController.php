<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiWishController extends AbstractController
{
    /**
     * @Route("/wish", name="api_wish_show", methods={"GET"})
     */
    public function showWish(WishRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    /**
     * @Route("/wish", name="api_wish_add", methods={"POST"})
     */
    public function addWish(Request $request): Response
    {        
        $wish = json_decode($request->getContent());

        $tab['info'] = 'Ajouter à la liste des wish: ' . ' ' . $wish->title . ' ' . $wish->description;
        
        return $this->json($tab);
    }

    /**
     * @Route("/wish/{id}", name="api_wish_edit", methods={"PUT"})
     */
    public function editWish($id): Response
    {
        $tab['info'] = 'Modifier un wish' .' ' .$id;
        
        return $this->json($tab);
    }

    /**
     * @Route("/wish/{id}", name="api_wish_delete", methods={"DELETE"})
     */
    public function deleteWish($id): Response
    {
        $tab['info'] = 'Effacter un wish' .' ' .$id;
        
        return $this->json($tab);
    }
}
