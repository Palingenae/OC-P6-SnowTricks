<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TrickController extends AbstractController
{
    private TrickRepository $trickRepository;

    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }
    
    public function index(): Response
    {
        $tricks = $this->trickRepository->findBy([],['id'=> 'DESC'], 6);

        return $this->render('homepage.html.twig', [
            'tricks' => $tricks
        ]);
    }
}