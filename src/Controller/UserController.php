<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserType;

class UserController extends AbstractController
{
    #[Route('/inscription', priority:10, name: 'user_register', methods:['GET', 'POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "Inscription Reussie. Vous pouvez désormais vous connecter a ActuNews");
        }
        return $this->render('user/register.html.twig', ['form' => $form]);
    }
}