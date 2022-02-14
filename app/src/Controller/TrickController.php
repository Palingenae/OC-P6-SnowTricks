<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Trick;
use App\Form\MessagingFormType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class TrickController extends AbstractController
{
    private TrickRepository $trickRepository;

    private EntityManagerInterface $manager;

    public function __construct(TrickRepository $trickRepository, EntityManagerInterface $manager)
    {
        $this->trickRepository = $trickRepository;
        $this->manager = $manager;
    }

    public function index(): Response
    {
        $tricks = $this->trickRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('homepage.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    public function getAllTricks(): Response
    {
        $tricks = $this->trickRepository->findAll();

        return $this->render('tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    public function getOneTrick(string $slug, Request $request, Security $security): Response
    {
        $trick = $this->trickRepository->findOneBy([
            'slug' => $slug,
        ]);

        $message = new Message();
        $form = $this->createForm(MessagingFormType::class, $message);
        $form->handleRequest($request);

        $user = $security->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $message->setWriter($user);
            $message->setTrick($trick);
            $message->setCreatedAt(new DateTime('now'));

            $this->manager->persist($message);
            $this->manager->flush();

            return $this->redirectToRoute('display_trick', [
                'slug' => $slug
            ]);
        }

        return $this->render('trick.html.twig', [
            'trick' => $trick,
            'user' => $user,
            'messageTrickForm' => $form->createView()
        ]);
    }

    public function createTrick(Request $request): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            echo "hello";
        }

        return $this->render('new_trick.html.twig', [
            'trick' => $trick,
            'createTrickForm' => $form->createView(),
        ]);
    }
}
