<?php

namespace App\Entity;

use App\Repository\CounterRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CounterRepository::class)]
class Counter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\NotBlank]
    #[Assert\Type("string")]
    #[ORM\Column(length: 255, unique: true)]
    private string $name;

    #[Assert\Type(DateTime::class)]
    #[ORM\Column(name: "started_at", type: Types::DATETIME_MUTABLE, nullable: true)]
    private DateTime|null $startedAt;

    #[Assert\Type("integer")]
    #[ORM\Column(name: "time_added", type: Types::INTEGER, nullable: true)]
    private int|null $timeAdded;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Counter
     */
    public function setName(string $name): Counter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getStartedAt(): ?DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param DateTime $startedAt
     * @return $this
     */
    public function setStartedAt(DateTime $startedAt): Counter
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTimeAdded(): ?int
    {
        return $this->timeAdded;
    }

    /**
     * @param int $timeAdded
     * @return $this
     */
    public function setTimeAdded(int $timeAdded): Counter
    {
        $this->timeAdded = $timeAdded;
        return $this;
    }
}