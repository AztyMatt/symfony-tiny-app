<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('_username');
            $password = $request->request->get('_password');
            $repeatPassword = $request->request->get('_repeat_password');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Invalid email address.';
            } elseif ($password !== $repeatPassword) {
                $error = 'Passwords do not match.';
            } else {
                $existingUser = $doctrine->getRepository(User::class)->findOneBy(['email' => $email]);

                if ($existingUser) {
                    $error = 'Email address already in use.';
                } else {
                    $username = strstr($email, '@', true);

                    $user = new User();
                    $user->setEmail($email);
                    $user->setPlainPassword($password);
                    $user->setUsername($username);
                    $user->setProfilePicture('https://avatar.iran.liara.run/public/'.rand(1, 100));

                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_login');
                }
            }
        }

        return $this->render('security/register.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route(path: '/forgot', name: 'app_forgot')]
    public function forgot(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            // Needs to check if reset token is already set !
            $email = $request->get('_username');
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('error', 'User not found.');
                return $this->redirectToRoute('app_forgot');
            } else {
                // Generate a reset token
                $resetToken = Uuid::v4();
                $user->setResetToken($resetToken);
                $entityManager->persist($user);
                $entityManager->flush();

                // Create the email
                $resetUrl = $this->generateUrl('reset', ['token' => $resetToken], 0); // 0 means to ignore the domain name in the URL
                $emailMessage = (new TemplatedEmail())
                    ->from('no-reply@next-task.com')
                    ->to($email)
                    ->subject('Password Reset Request')
                    ->htmlTemplate('email/reset.html.twig')
                    ->context([
                        'resetToken' => $resetToken,
                        '_username' => $email
                    ]);

                // Send the email
                $mailer->send($emailMessage);

                $this->addFlash('success', 'A reset email has been sent.');
                return $this->redirectToRoute('app_forgot');
            }
        }

        return $this->render(view: 'security/forgot.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/reset/{token}', name: 'reset')]
    public function reset(string $token, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        if (!Uuid::isValid($token)) {
            $this->addFlash('error', 'Invalid reset token.');
            return $this->redirectToRoute('app_forgot');
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Invalid or expired reset token.');
            return $this->redirectToRoute('app_forgot');
        }

        if ($request->isMethod('POST')) {
            $password = $request->get('_password');
            $repeatPassword = $request->get('_repeat_password');

            if (empty($password) || empty($repeatPassword)) {
                $this->addFlash('error', 'Password cannot be empty.');
                return $this->redirectToRoute('reset', ['token' => $token]);
            }

            if ($password !== $repeatPassword) {
                $this->addFlash('error', 'Passwords do not match.');
                return $this->redirectToRoute('reset', ['token' => $token]);
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
            $user->setResetToken(null); // Clear the reset token
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset.html.twig', [
            'token' => $token,
            'email' => $user->getEmail()
        ]);
    }
}
