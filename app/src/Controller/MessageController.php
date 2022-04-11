<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends AbstractController
{
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function writeTrickMessage(): Response 
    {
        $message = new Message();

        $form = $this->createForm(MessageFormType::class, $message);

        return $this->renderForm('components/message_form.html.twig', [
            'messageTrickForm' => $form
        ]);
    }
}
