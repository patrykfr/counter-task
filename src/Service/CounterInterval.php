<?php

namespace App\Service;

use App\Entity\Counter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CounterInterval extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('calculateDiff', [$this, 'calculateDiff']),
        ];
    }

    /**
     * @param Counter $counter
     * @return int
     */
    public function calculateDiff(Counter $counter): int
    {
        if (!$counter->getStartedAt()) {
            return 0;
        }

        $now = new \DateTime('now');
        $diff = $now->getTimestamp() - $counter->getStartedAt()->getTimestamp();

        return $diff + $counter->getTimeAdded();
    }
}