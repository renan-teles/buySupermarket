<?php

abstract class ItemPurchase
{
    private int $id;
    private int $idPurchase;
    private int $idUnit;
    private string $name;
    private float $quantity;

    public function __construct(int $idPurchase, int $idUnit, string $name, float $quantity)
    {
        $this->id = 0;
        $this->idPurchase = $idPurchase;
        $this->idUnit = $idUnit;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdPurchase(): int
    {
        return $this->idPurchase;
    }

    public function getIdUnit(): int
    {
        return $this->idUnit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdPurchase(int $idPurchase): void
    {
        $this->idPurchase = $idPurchase;
    }

    public function setIdUnit(int $idUnit): void
    {
        $this->idUnit = $idUnit;
    }

    public function setName(string $name): void 
    {
        $this->name = $name;
    }

    public function setQuantity(int $quantity): void
    {   
        $this->quantity = $quantity;
    }
}
