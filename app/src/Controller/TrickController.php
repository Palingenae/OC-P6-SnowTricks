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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        $form = $this->createForm(MessagingFormType::class);
        $form->handleRequest($request);

        $messageWriter = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $messageWriter = $security->getUser();

            $message = $form->getData();
            $message->setWriter($messageWriter);
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
            'messageWriter' => $messageWriter,
            'messageTrickForm' => $form->createView()
        ]);
    }

    public function createTrick(Request $request, Security $security, SluggerInterface $slugger): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        $user = $security->getUser();

        if($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();

            /** @var UploadedFile $coverImage */
            $coverImageUrl = $form->get('coverImage')->get('url')->getData();
            $coverImage = $form->get('coverImage')->getData();

            if($coverImageUrl) {
                $coverImageName = $trick->getSlug() . '-' . uniqid() . '.' . $coverImageUrl->guessExtension();

                try {
                    $coverImageUrl->move(
                        $this->getParameter('images_directory'),
                        $coverImageName
                    );
                } catch (FileException $fileException) {
                    $fileException->getMessage();
                }

                $coverImage->setName($coverImageName);
                $coverImage->setUrl($this->getParameter('images_url') . $coverImageName);

                $this->manager->persist($coverImage);
                $this->manager->flush();
            }
            
            $trickImagesCollection = $form->get('images');

            foreach($trickImagesCollection as $trickImageTemp) {
                /** @var UploadedFile $trickImageUrl */
                $trickImageUrl = $trickImageTemp->get('url')->getData();
                $trickImage = $trickImageTemp->getData();
                
                if($trickImageUrl) {
                    $trickImageName = $trick->getSlug() . '-' . uniqid() . '-' . $trickImageUrl->guessExtension();

                    try {
                        $trickImageUrl->move(
                            $this->getParameter('images_directory'),
                            $trickImageName
                        );
                    } catch(FileException $fileException) {
                        $fileException->getMessage();
                    }

                    $trickImage->setName($trickImageName);
                    $trickImage->setUrl($this->getParameter('images_url') . $coverImageName);

                    $this->manager->persist($trick);

                    $trickImage->setTrick($trick);

                    $this->manager->persist($trickImage);

                    $trick->addImage($trickImage);
                }
            }

            $trick->setCoverImage($coverImage);
            
            $this->manager->persist($trick);
            $this->manager->flush();

            return $this->redirectToRoute('display_trick', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('new_trick.html.twig', [
            'trick' => $trick,
            'createTrickForm' => $form->createView(),
        ]);
    }
}
