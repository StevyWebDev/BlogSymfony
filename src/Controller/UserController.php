<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/utilisateur', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/connexion', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $identifier = $authenticationUtils->getLastUsername();

        if($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('user/login.html.twig', [
            'last_username' => $identifier,
            'error'         => $error,
        ]);
    }

    #[Route('/deconnexion', name: 'logout')]
    public function logout(): Void {}

    #[Route('/show', name: 'show')]
    #[IsGranted('ROLE_ADMIN')]
    public function show(UserRepository $users): Response {
        return $this->render('user/show.html.twig', [
            'users' => $users->findAll()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(User $user, EntityManagerInterface $manager): Response {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/update/{id}', name: 'update')]
    #[IsGranted('ROLE_ADMIN')]
    public function update(User $user, EntityManagerInterface $manager, Request $request): Response {
        $form = $this->createForm(UpdateUserType::class, $user);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }


        return $this->render('user/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
