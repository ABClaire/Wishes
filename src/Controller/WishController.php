<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Diff\Diff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Timezone;

class WishController extends AbstractController
{

    /**
     * @Route("/", name="list")
     */
    public function list(WishRepository $repo): Response
    {
        $list = $repo->findAll();

        return $this->render('wish/index.html.twig', [
            'titre' => "My wish list",
            'list' => $list
        ]);
    }


    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(Wish $myWish): Response
    {        
        
        return $this->render('wish/detail.html.twig', [
            'titre' => "Wish details",
            'myWish' => $myWish
        ]);
        
    }

     /**
     * @Route("/add-wish", name="add_wish")
     */
    public function addWish(Request $request, EntityManagerInterface $em): Response
    {
        // Create the object
        $wish = new Wish();
        $wish->setIsPublished('true');
        $wish->setDateCreated(new \DateTime('now', new DateTimeZone('Europe/Paris')));
        
        // Association
        $form = $this->createForm(WishType::class, $wish);

        // Auto-hydratation
        $form->handleRequest($request);

        // Action when submit
        if($form->isSubmitted() && $form->isValid()){
            $dateNaissance = $form->get('dateNaissance')->getData();
            $age = $dateNaissance->diff(new \DateTime('now'));
        
            if((int)$age->format('%y') >= 18) {
                $em->persist($wish);
                $em->flush();
                $this->addFlash('success', 'Your wish '. $wish->getTitle() .' is added!'); 
                return $this->redirectToRoute('list');
            } else {
                $this->addFlash('danger', 'You must be more than 18 to make a wish. Sorry!');
            }
        } 

        // Link with the template
        return $this->render('wish/addWish.html.twig', [
            'titre' => 'Add a new wish',
            'formulaire' => $form->createView()
        ]);

    }


     /**
     * @Route("/edit-wish/{id}", name="edit_wish")
     */
    public function editWish(Wish $wish, Request $request, EntityManagerInterface $em): Response
    {
        // Association
        $form = $this->createForm(WishType::class, $wish);

        // Auto-hydratation
        $form->handleRequest($request);

        // Action when submit
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'Your wish ' . $wish->getTitle() . ' is changed!');
            return $this->redirectToRoute('list');
 
        } 

        // Link with the template
        return $this->render('wish/editWish.html.twig', [
            'titre' => 'Edit your wish',
            'formulaire' => $form->createView()
        ]);

    }


    /**
     * @Route("/delete-wish/{id}", name="delete_wish")
     */
    public function deleteWish(EntityManagerInterface $em, Wish $myWish): Response
    {
        $em->remove($myWish);
        $em->flush();

        return $this->redirectToRoute('list');

    }

}
