<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post_')]
class PostController extends AbstractController
{
    #[Route('/view', name: 'view')]
    public function index(PostRepository $posts): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/find/{id<\d+>}', name: 'findOne')]
    public function findOne(Post $post): Response
    {
        return $this->render('post/findOne.html.twig', [
            'post' =>  $post
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    #[IsGranted('ROLE_EDITOR')]
    public function delete(Post $post, EntityManagerInterface $manager): Response
    {
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('post_view');
    }

    #[Route('/formulaire/editor/{id?}', name: 'form')]
    #[IsGranted('ROLE_EDITOR')]
    public function create(Post $post = null, Request $request, EntityManagerInterface $manager): Response
    {

        if (!$post) {
            $post = new Post();
            $post->setCreatedAt(new \DateTimeImmutable('now'));
        }
        $form = $this->createForm(PostType::class, $post);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $post
                ->setUpdateAt(new \DateTimeImmutable('now'))
                ->setPublished(true);

            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('post/form.html.twig', [
            'form' => $form
        ]);
    }
}
