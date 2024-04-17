<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/administration/article')]
class PostController extends AbstractController
{
    #[Route('/creer-un-article.html', name: 'post_create')]
    public function create(Request $request,
                           SluggerInterface $slugger,
                           EntityManagerInterface $manager): Response
    {

        $post = new Post();
        $post->setUpdatedAt(new \DateTimeImmutable());
        $post->setCreatedAt(new \DateTimeImmutable());

        $user = $this->getUser();

        $post->setUser($user);

        //PostType::class => namespace de la classe
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                # Déplacement du fichier dans le dossier upload
                try {
                    $imageFile->move(
                        $this->getParameter('posts_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $post->setImage($newFilename);
            }
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Article enregistré');

            return $this->redirectToRoute('/category/{slug}', [
                'category' => $post->getCategories()[0]->getSlug(),
                'slug' => $post->getSlug()
            ]);
        }
        return $this->render('post/create.html.twig', ['form' => $form ]);
    }
}