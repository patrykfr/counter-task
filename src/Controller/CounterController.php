<?php

namespace App\Controller;

use App\Entity\Counter;
use App\Repository\CounterRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class CounterController extends AbstractController
{
    #[Route('/counter/{name}', name: 'counter', methods: ["GET"])]
    public function counter(ManagerRegistry $doctrine, string $name): Response
    {
        /* @var CounterRepository $counterRepository */
        $counterRepository = $doctrine->getRepository(Counter::class);
        /* @var Counter $counter */
        $counter = $counterRepository->findOneBy(['name' => $name]);

        if (!$counter) {
            throw $this->createNotFoundException(
                'No counter found for name '. $name
            );
        }

        if (!$counter->getStartedAt()) {
            $counter->setStartedAt(new DateTime('now'));
            $counterRepository->save($counter, true);
        }

        return $this->render('counter.html.twig', [
            'counter' => $counter
        ]);
    }
}