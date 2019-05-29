<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quanityGram;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityUnit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeRecette", mappedBy="id_Order")
     */
    private $commandeRecettes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeStock", mappedBy="id_order")
     */
    private $commandeStocks;

    public function __construct()
    {
        $this->id_Recette = new ArrayCollection();
        $this->commandeRecettes = new ArrayCollection();
        $this->commandeStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuanityGram(): ?int
    {
        return $this->quanityGram;
    }

    public function setQuanityGram(?int $quanityGram): self
    {
        $this->quanityGram = $quanityGram;

        return $this;
    }

    public function getQuantityUnit(): ?int
    {
        return $this->quantityUnit;
    }

    public function setQuantityUnit(?int $quantityUnit): self
    {
        $this->quantityUnit = $quantityUnit;

        return $this;
    }

    /**
     * @return Collection|CommandeRecette[]
     */
    public function getCommandeRecettes(): Collection
    {
        return $this->commandeRecettes;
    }

    public function addCommandeRecette(CommandeRecette $commandeRecette): self
    {
        if (!$this->commandeRecettes->contains($commandeRecette)) {
            $this->commandeRecettes[] = $commandeRecette;
            $commandeRecette->setIdOrder($this);
        }

        return $this;
    }

    public function removeCommandeRecette(CommandeRecette $commandeRecette): self
    {
        if ($this->commandeRecettes->contains($commandeRecette)) {
            $this->commandeRecettes->removeElement($commandeRecette);
            // set the owning side to null (unless already changed)
            if ($commandeRecette->getIdOrder() === $this) {
                $commandeRecette->setIdOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommandeStock[]
     */
    public function getCommandeStocks(): Collection
    {
        return $this->commandeStocks;
    }

    public function addCommandeStock(CommandeStock $commandeStock): self
    {
        if (!$this->commandeStocks->contains($commandeStock)) {
            $this->commandeStocks[] = $commandeStock;
            $commandeStock->setIdOrder($this);
        }

        return $this;
    }

    public function removeCommandeStock(CommandeStock $commandeStock): self
    {
        if ($this->commandeStocks->contains($commandeStock)) {
            $this->commandeStocks->removeElement($commandeStock);
            // set the owning side to null (unless already changed)
            if ($commandeStock->getIdOrder() === $this) {
                $commandeStock->setIdOrder(null);
            }
        }

        return $this;
    }

}
