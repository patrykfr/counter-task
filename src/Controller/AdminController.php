<?php

namespace App\Controller;

use App\Entity\Counter;
use App\Form\CounterType;
use App\Repository\CounterRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/counters', name: 'counters_list', methods: ["GET"])]
    public function countersList(ManagerRegistry $doctrine): Response
    {
        $counterRepository = $doctrine->getRepository(Counter::class);
        $counters = $counterRepository->findBy([], ['name' => 'ASC']);

//        TODO: add pagination

        return $this->render('Admin/counters.html.twig', [
            'counters' => $counters
        ]);
    }

    #[Route('/counter/create', name: 'counter_create', methods: ["GET", "POST"])]
    #[Route('/counter/edit/{name}', name: 'counter_edit', methods: ["GET", "POST"])]
    public function edit(Request $request, ManagerRegistry $doctrine, ?string $name): Response
    {
        /* @var CounterRepository $counterRepository */
        $counterRepository = $doctrine->getRepository(Counter::class);
        $counter = new Counter();

        if ($name) {
            $counter = $counterRepository->findOneBy(['name' => $name]);

            if (!$counter) {
                throw $this->createNotFoundException(
                    'No counter found for name '. $name
                );
            }
        }

        $form = $this->createForm(CounterType::class, $counter, [
            "method" => "POST"
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $counter = $form->getData();
            $counterRepository->save($counter, true);

            return $this->redirectToRoute('admin_counters_list');
        }

        return $this->render('Admin/counter.html.twig', [
            'form' => $form,
        ]);
    }
}
