<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/email', name: 'email')]
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
        if ($request->request->get('email') && $request->request->get('subject') && $request->request->get('message')) {

            $message = $request->request->get('message');
            $email = (new Email())
                ->from($request->request->get('email'))
                ->to('you@example.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($request->request->get('subject'))
                ->text($message)
                ->html("<p>$message</p>");

            $mailer->send($email);
        }

        return $this->redirectToRoute('home');
    }

}
