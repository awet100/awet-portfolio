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
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => $request->query->get('message'),
            'status' => $request->query->get('status'),
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/email', name: 'email')]
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
        $message = "";
        $status = "";

        if (filter_var($request->request->get('email'), FILTER_VALIDATE_EMAIL)) {

            $message = $request->request->get('message');
            $email = (new Email())
                ->from($request->request->get('email'))
                ->to('you@example.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($request->request->get('subject'))
                ->text($message)
                ->html("<p>$message</p>");

            $mailer->send($email);

            $message = "Form successful submitted, Thank you for contacting Mr/Ms {$request->request->get('name')}";
            $status = true;
        } else {
            $message = "Email address {$request->request->get('email')} is considered invalid.\n";
            $status = false;
        }

        return $this->redirectToRoute('home', ['message' => $message, 'status' => $status]);
    }

}
