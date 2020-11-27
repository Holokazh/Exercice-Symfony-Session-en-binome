<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\RegisterType;

use App\Form\ChangePasswordType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Form\ForgottenPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/directors/register", name="user_register")
     */
    public function register(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('listAllUsers');
        }

        return $this->render('security/register.html.twig', [
            'formRegister' => $form->createView(),
            'title' => 'Inscription'
        ]);
    }

    /**
     * @Route("/directors/{id}/edit", name="user_edit")
     */
    public function editUser(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('listAllUsers');
        }

        return $this->render('user/edit.html.twig', [
            'formEditUser' => $form->createView(),
            'title' => 'Modifier un utilisateur'
        ]);
    }

    /**
     * @Route("/user/{id}/changePassword", name="user_changePassword")
     */
    public function changePassword(User $user = null, EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(ChangePasswordType::class, $user);
        // $formOldPsw = $form->get('oldPassword')->getData();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {

                $newPassword = $form->get('newPassword')->getData();
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $newPassword
                    )
                );

                $manager->flush();
                $this->addFlash('info', 'Votre mot de passe a bien été changé !');

                return $this->redirectToRoute('listAllUsers');
            }
        }

        return $this->render('security/changePassword.html.twig', [
            'formChangePassword' => $form->createView(),
            'title' => 'Modifier votre mot de passe'
        ]);
    }

    /**
     * @Route("/security/forgotten_password", name="app_forgotten_password")
     */
    public function forgottenPassword(User $user = null, EntityManagerInterface $manager, Request $request, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UserRepository $userRepository): Response
    {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);
        $email = $form->get('emailResetPsw')->getData();
        $user = $userRepository->findOneByEmail($email);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $token = $tokenGenerator->generateToken();
                try {
                    $user->setResetToken($token);
                    $manager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('Warning', $e->getMessage());
                    return $this->redirectToRoute('app_login');
                }

                $url = $this->generateUrl('security_resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);



                $message = (new Email())
                    ->from('vb.formation68@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Récupération de mdp test')
                    ->text("VOICI LE LIEN DE RECUPERATION DE VOTRE MOT DE PASSE : " . $url, 'text/html')
                    ->html("<p> VOICI LE LIEN DE RECUPERATION DE VOTRE MOT DE PASSE : " . $url, 'text/html' . "</p>");

                $mailer->send($message);

                // return $this->redirectToRoute('app_login');
                $this->addFlash('info', 'Le mail de récupération de mot de passe a bien été envoyé, vous pouvez aller le consulter.');

            }
        }

        return $this->render('security/forgottenPassword.html.twig', [
            'formForgottenPassword' => $form->createView(),
            'title' => 'Réinitialisation de mot de passe'
        ]);
    }

    /**
     * @Route("/security/resetPassword/{token}", name="security_resetPassword")
     */
    public function resetPassword(User $user = null, EntityManagerInterface $manager, Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        // Redéfinir le user
        $user = $userRepository->findOneByResetToken($token);

        if ($form->isSubmitted() && $form->isValid()) {
            // Revérifier si on est en méthode "POST"
            if ($request->isMethod('POST')) {
                // On va reset le token à NULL (setResetToken=NULL)
                $user->setResetToken(NULL);

                // On va set le password et l'encoder, puis flush
                $newPassword = $form->get('newPassword')->getData();
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $newPassword
                    )
                );
                
                $manager->flush();
                $this->addFlash('info', 'Votre mot de passe a bien été changé !');

                return $this->redirectToRoute('app_login');
            }
        }


        return $this->render('/security/resetPassword.html.twig', [
            'token' => $token,
            'formResetPassword' => $form->createView(),
            'title' => 'Réinitialisation de mot de passe'
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
