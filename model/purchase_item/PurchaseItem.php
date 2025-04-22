<?php

require_once __DIR__ . '/../autoRequireClass.php';

class PurchaseItem extends ItemPurchase
{
    private float $price;

    public function __construct(int $idPurchase, int $idUnit, string $name, float $quantity, float $price)
    {
        parent::__construct($idPurchase, $idUnit, $name, $quantity);
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}