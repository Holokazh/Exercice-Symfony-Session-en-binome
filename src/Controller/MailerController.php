<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\ForgottenPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class MailerController extends AbstractController
{
    // /**
    //  * @Route("/email", name="app_mailer_sendemail")
    //  */
    // public function forgottenPassword(User $user, EntityManagerInterface $manager, Request $request, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    // {
    //     $form = $this->createForm(ForgottenPasswordType::class);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($request->isMethod('POST')) {
    //             $email = $form->get('emailResetPsw')->getData();
    //             $user = $manager->getRepository(User::class)->findOneByEmail($email);
    //             $token = $tokenGenerator->generateToken();
    //             try {
    //                 $user->setResetToken($token);
    //                 $manager->flush();
    //             } catch (\Exception $e) {
    //                 $this->addFlash('Warning', $e->getMessage());
    //                 return $this->redirectToRoute('app_login');
    //             }

    //             $url = $this->generateUrl('reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);



    //             $message = (new Email())
    //                 ->from('vb.formation68@gmail.com')
    //                 ->to($email)
    //                 ->subject('Récupération de mdp test')
    //                 ->text("VOICI LE LIEN DE RECUPERATION DE VOTRE MOT DE PASSE : " . $url, 'text/html')
    //                 ->html('<p>See Twig integration for better HTML integration!</p>');

    //             $mailer->send($message);

    //             return $this->redirectToRoute('app_login');
    //         }
    //     }

    //     return $this->render('security/forgottenPassword.html.twig', [
    //         'formForgottenPassword' => $form->createView(),
    //         'title' => 'Récupération de mot de passe'
    //     ]);
    // }
}
