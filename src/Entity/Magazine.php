<?php

namespace App\Entity;

use App\Model\SalableInterface;
use App\Repository\MagazineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MagazineRepository::class)
 */
class Magazine extends Salable implements SalableInterface
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $issueNumber;

    public function getIssueNumber(): ?string
    {
        return $this->issueNumber;
    }

    public function setIssueNumber(?string $issueNumber): self
    {
        $this->issueNumber = $issueNumber;

        return $this;
    }
}
