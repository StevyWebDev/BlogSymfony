<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/formulaire/{id}', name: 'form')]
    #[IsGranted('ROLE_USER')]
    public function create(Post $post, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $comment
                ->setPost($post)
                ->setUser($this->getUser())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdateAt(new \DateTimeImmutable())
            ;

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('post_findOne', [
                'id' => $post->getId()
            ]);
        }

        return $this->render('comment/form.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }
}
