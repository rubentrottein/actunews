<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RenderController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function renderSidebar(PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        $posts = $this->manager->getRepository(Post::class, Category::class)
            ->findBy([], ['publishedAt' => 'DESC'], 3);

        return $this->render('components/_sidebar.html.twig', [
            'posts' => $posts
//            'categorie' => $categorie
        ]);
    }
    public function renderNavigation(): Response
    {
        $categories = $this->manager->getRepository(Category::class)->findAll();

        return $this->render('components/_nav.html.twig', [
            'categories' => $categories
        ]);
    }
}