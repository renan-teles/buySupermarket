<?php

require_once __DIR__ . '/../autoRequireClass.php';

class PlannedPurchaseItemDAO extends ClassDAO
{
    private PlannedPurchaseItem $plannedPurchaseItem;

    public function __construct(PlannedPurchaseItem $plannedPurchaseItem, ConnectionDB $connectionDB)
    {
        $this->plannedPurchaseItem = $plannedPurchaseItem;
        parent::__construct($connectionDB);
    }

    public function deletePlannedPurchaseItem(): bool
    {
        try {
            $id = $this->getPlannedPurchaseItem()->getId();

            $pdo = $this->getConnectionDB()->getConnection();

            $sql = "DELETE FROM planned_purchases_items WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao deletar item da compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function editPlannedPurchaseItem(): bool
    {
        try {
            $id = $this->getPlannedPurchaseItem()->getId();
            $name = $this->getPlannedPurchaseItem()->getName();
            $idUnit = $this->getPlannedPurchaseItem()->getIdUnit();
            $quantity = $this->getPlannedPurchaseItem()->getQuantity();

            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql = "UPDATE planned_purchases_items 
                    SET 
                        id_unit = :idUnit,
                        name = :name, 
                        quantity = :quantity
                    WHERE id = :id";

            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':idUnit', $idUnit);
            $query->bindValue(':name', $name);
            $query->bindValue(':quantity', $quantity);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao editar item da compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function getPlannedPurchaseItem(): PlannedPurchaseItem
    {
        return $this->plannedPurchaseItem;
    }

    public function registerPlannedPurchaseItem(): bool
    {
        try {
            $idPurchase = $this->getPlannedPurchaseItem()->getIdPurchase();
            $name = $this->getPlannedPurchaseItem()->getName();
            $idUnit = $this->getPlannedPurchaseItem()->getIdUnit();
            $quantity = $this->getPlannedPurchaseItem()->getQuantity();

            $pdo = $this->getConnectionDB()->getConnection();
        
            $sql = "INSERT INTO 
                        planned_purchases_items 
                        (id_purchase, id_unit, name, quantity) 
                    VALUES 
                        (:idPurchase, :idUnit, :name,  :quantity)";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':idPurchase', $idPurchase);
            $query->bindValue(':idUnit', $idUnit);
            $query->bindValue(':name', $name);
            $query->bindValue(':quantity', $quantity);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao adicionar items a compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function searchPlannedPurchaseItemsByIdPurchase(): bool | array
    {
        try {
            $idPurchase = $this->getPlannedPurchaseItem()->getIdPurchase();
    
            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql = "SELECT 
                        ppi.id, ppi.name, ppi.quantity, unt.name as unit_measurement
                    FROM 
                        planned_purchases_items ppi
                    INNER JOIN units unt ON ppi.id_unit = unt.id 
                    WHERE ppi.id_purchase = :idPurchase ORDER BY name asc;";
    
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