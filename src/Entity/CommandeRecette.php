<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRecetteRepository")
 */
class CommandeRecette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="commandeRecettes")
     */
    private $id_Order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recette", inversedBy="commandeRecettes")
     */
    private $id_Recette;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrder(): ?Order
    {
        return $this->id_Order;
    }

    public function setIdOrder(?Order $id_Order): self
    {
        $this->id_Order = $id_Order;

        return $this;
    }

    public function getIdRecette(): ?Recette
    {
        return $this->id_Recette;
    }

    public function setIdRecette(?Recette $id_Recette): self
    {
        $this->id_Recette = $id_Recette;

        return $this;
    }
}
