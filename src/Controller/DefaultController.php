<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home(PostRepository $postRepository) : Response
    {


        #1. Récupération des derniers articles
        $posts = $postRepository->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('default/home.html.twig', [
                'posts' => $posts
        ]);

    }
    #[Route('/contact', name: 'default_contact', methods: ['GET'])]
    public function contact () : Response
    {
        return $this->render('default/contact.html.twig');
    }

    #[Route('/{slug}', name: 'default_category', methods: ['GET'])]
    public function category(Category $category): Response
    {
        # Méthode 1
        # $category = $categoryRepository->findOneBy(['slug' => $slug]);

        # Méthode 2
        # $category = $categoryRepository->findOneBySlug($slug);
        # dd($category);

        return $this->render('default/category.html.twig', [
        'category' => $category
    ]);
    }

    /**
     * @param $category
     * @param $slug
     * @return Response
     * https://localhost:/categorie/alias
     */
    #[Route('/{category}/{slug}', name: 'default_post', methods: ['GET'], priority:1)]
    public function post($category, $slug) : Response
    {
        return $this->render('default/home.html.twig');
    }
}