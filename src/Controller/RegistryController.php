<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistryController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
//        TODO: check user in db
        $user = new User();

        $form = $this->createForm(UserType::class, $user, [
            "method" => "POST"
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('register.html.twig', [
            'form' => $form,
        ]);
    }
}