<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRecetteRepository")
 */
class ProductRecette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productRecettes")
     */
    private $id_Product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recette", inversedBy="productRecettes")
     */
    private $id_Recette;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduct(): ?Product
    {
        return $this->id_Product;
    }

    public function setIdProduct(?Product $id_Product): self
    {
        $this->id_Product = $id_Product;

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
