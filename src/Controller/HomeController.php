<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $resa = new Reservation();
        $form = $this->createForm(ReservationType::class, $resa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $resa = $form->getData();
            $this->entityManager->persist($resa);
            $this->entityManager->flush();
            dd($resa);
        }


        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
