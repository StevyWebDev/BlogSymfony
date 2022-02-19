<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category_view')]
    public function index(): Response
    {
        return $this->render('category/form.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/formulaire/{id?}', name: 'category_form')]
    #[IsGranted('ROLE_EDITOR')]
    public function form(Category $category = null ,EntityManagerInterface $manager, Request $request): Response
    {
        if(!$category) {
            $category = new Category();
        }
        $form = $this->createForm(CategoryType::class, $category);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('category/form.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/delete/{id}', name: 'category_delete')]
    #[IsGranted('ROLE_EDITOR')]
    public function delete(Category $category ,EntityManagerInterface $manager): Response
    {
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('home');
    }

}
