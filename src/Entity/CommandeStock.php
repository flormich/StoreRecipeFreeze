<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeStockRepository")
 */
class CommandeStock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="commandeStocks")
     */
    private $id_stock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="commandeStocks")
     */
    private $id_order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStock(): ?Stock
    {
        return $this->id_stock;
    }

    public function setIdStock(?Stock $id_stock): self
    {
        $this->id_stock = $id_stock;

        return $this;
    }

    public function getIdOrder(): ?Order
    {
        return $this->id_order;
    }

    public function setIdOrder(?Order $id_order): self
    {
        $this->id_order = $id_order;

        return $this;
    }
}
