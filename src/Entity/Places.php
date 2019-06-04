<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlacesRepository")
 */
class Places
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $name;

    // /**
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
    // private $drawers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // public function getDrawers(): ?int
    // {
    //     return $this->drawers;
    // }

    // public function setDrawers(?int $drawers): self
    // {
    //     $this->drawers = $drawers;

    //     return $this;
    // }
}
