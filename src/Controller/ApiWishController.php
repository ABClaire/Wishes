<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Wish;
use App\Repository\CategorieRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function addWish(Request $request, EntityManagerInterface $em, CategorieRepository $repo): Response
    {        
        // Retrieve information from the API body
        $body = json_decode($request->getContent());
        $categorie = $repo->find($body->categorieId);

        // Create the object and set it
        $wish = new Wish();
        $wish->setTitle($body->title);
        $wish->setDescription($body->description);
        $wish->setAuthor($body->author);
        $wish->setCategorie($categorie);
        $wish->setIsPublished('true');
        $wish->setDateCreated(new \DateTime('now'));

        // Add the object to the bdd
        $em->persist($wish);
        $em->flush();

        return $this->json($wish);
    }

    /**
     * @Route("/wish/{id}", name="api_wish_edit", methods={"PUT"})
     */
    public function editWish(Wish $wish, Request $request, EntityManagerInterface $em): Response
    {
        // Retrieve information from the API body
        $body = json_decode($request->getContent());

        // Create the object and set it
        $wish = new Wish();
        $wish->setTitle($body->title);
        $wish->setDescription($body->description);
        $wish->setAuthor($body->author);
        $wish->setDateCreated(new \DateTime('now'));

        // Add the object to the bdd
        $em->flush();

        return $this->json($wish);
    }

    /**
     * @Route("/wish/{id}", name="api_wish_delete", methods={"DELETE"})
     */
    public function deleteWish(EntityManagerInterface $em, Wish $wish): Response
    {
        // Remove
        $em->remove($wish);
        $em->flush();

        // Information
        $tab['info'] = 'The wish is erased';
        
        return $this->json($tab);
    }
}
