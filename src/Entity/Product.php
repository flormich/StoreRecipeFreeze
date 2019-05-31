<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryProduct", inversedBy="Products")
     */
    private $id_CategoryProduct;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PictureProduct", cascade={"persist", "remove"})
     */
    private $id_PictureProduct;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="id_product")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductRecette", mappedBy="id_Product")
     */
    private $productRecettes;

    public function __construct()
    {
        $this->productRecettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategoryProduct(): ?CategoryProduct
    {
        return $this->id_CategoryProduct;
    }

    public function setCategoryProduct(?CategoryProduct $id_CategoryProduct): self
    {
        $this->id_CategoryProduct = $id_CategoryProduct;

        return $this;
    }

    public function getIdPictureProduct(): ?PictureProduct
    {
        return $this->id_PictureProduct;
    }

    public function setIdPictureProduct(?PictureProduct $id_PictureProduct): self
    {
        $this->id_PictureProduct = $id_PictureProduct;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection|ProductRecette[]
     */
    public function getProductRecettes(): Collection
    {
        return $this->productRecettes;
    }

    public function addProductRecette(ProductRecette $productRecette): self
    {
        if (!$this->productRecettes->contains($productRecette)) {
            $this->productRecettes[] = $productRecette;
            $productRecette->setIdProduct($this);
        }

        return $this;
    }
}
