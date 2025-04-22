<?php

require_once __DIR__ . '/../autoRequireClass.php';

class PurchaseItemDAO extends ClassDAO
{
    private PurchaseItem $purchaseItem;

    public function __construct(PurchaseItem $purchaseItem, ConnectionDB $connectionDB)
    {
        $this->purchaseItem = $purchaseItem;
        parent::__construct($connectionDB);
    }

    public function deletePurchaseItem(): bool
    {
        try {
            $id = $this->getPurchaseItem()->getId();

            $pdo = $this->getConnectionDB()->getConnection();

            $sql = "DELETE FROM purchases_items WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao deletar item da compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function editPurchaseItem(): bool
    {
        try {
            $id = $this->getPurchaseItem()->getId();
            $name = $this->getPurchaseItem()->getName();
            $idUnit = $this->getPurchaseItem()->getIdUnit();
            $quantity = $this->getPurchaseItem()->getQuantity();
            $price = $this->getPurchaseItem()->getPrice();

            $pdo = $this->getConnectionDB()->getConnection();

            $sql = "UPDATE purchases_items 
                    SET 
                        id_unit = :idUnit,
                        name = :name, 
                        price = :price,
                        quantity = :quantity 
                    WHERE id = :id";

            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':idUnit', $idUnit);
            $query->bindValue(':name', $name);
            $query->bindValue(':price', $price); 
            $query->bindValue(':quantity', $quantity);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao editar item da compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function getPurchaseItem(): PurchaseItem
    {
        return $this->purchaseItem;
    }

    public function registerPurchaseItem(): bool
    {
        try {
            $idPurchase = $this->getPurchaseItem()->getIdPurchase();
            $name = $this->getPurchaseItem()->getName();
            $idUnit = $this->getPurchaseItem()->getIdUnit();
            $quantity = $this->getPurchaseItem()->getQuantity();
            $price = $this->getPurchaseItem()->getPrice();

            $pdo = $this->getConnectionDB()->getConnection();
        
            $sql = "INSERT INTO 
                        purchases_items 
                        (id_purchase, id_unit, name, price, quantity) 
                    VALUES 
                        (:idPurchase, :idUnit, :name, :price, :quantity)";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':idPurchase', $idPurchase);
            $query->bindValue(':idUnit', $idUnit);
            $query->bindValue(':name', $name);
            $query->bindValue(':price', $price); 
            $query->bindValue(':quantity', $quantity);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao adicionar items a compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function searchPurchaseItemsByIdPurchase(): bool | array
    {
        try {
            $idPurchase = $this->getPurchaseItem()->getIdPurchase();
    
            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql = "SELECT 
                        pi.id, pi.name, pi.price, pi.quantity, unt.name as unit_measurement
                    FROM 
                        purchases_items pi
                    INNER JOIN units unt ON pi.id_unit = unt.id 
                    WHERE pi.id_purchase = :idPurchase ORDER BY name asc;";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':idPurchase', $idPurchase);
            $query->execute();
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            error_log("Erro ao buscar items da compra do usuário: " . $exc->getMessage());
            return false;
        }
    }
}