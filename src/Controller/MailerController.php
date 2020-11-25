<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer, User $user)
    {
        $email = (new Email())
            ->from('vb.formation68@gmail.com')
            ->to($user->getEmail())
            ->subject('Récupération de mdp test')
            ->text('VOICI LE LIEN DE RECUPERATION DE VOTRE MOT DE PASSE')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        return $this->render('home/index.html.twig');
    }
}
