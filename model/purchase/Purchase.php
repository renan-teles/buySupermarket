<?php

class Purchase 
{
    private int $id;
    private int $idUser;
    private string $name;
    private float $maxSpend;
    private float $totalValue;
    private int $totalItems;
    
    public function __construct(string $name, float $maxSpend, int $idUser) 
    {
        $this->id = 0;
        $this->idUser = $idUser;
        $this->name = $name;
        $this->maxSpend = $maxSpend;
        $this->totalValue = 0;
        $this->totalItems = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getMaxSpend(): float
    {
        return $this->maxSpend;
    }
   
    public function getTotalValue(): float
    {
        return $this->totalValue;
    }
   
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }
    
    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function setIdUser(int $idUser): void 
    {
        $this->idUser = $idUser;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setMaxSpend(float $maxSpend): void 
    {
        $this->maxSpend = $maxSpend;
    }
    
    public function setTotalValue(float $totalValue): void 
    {
        $this->totalValue = $totalValue;
    }
    
    public function setTotalItems(int $totalItems): void 
    {
        $this->totalItems = $totalItems;
    }
}
