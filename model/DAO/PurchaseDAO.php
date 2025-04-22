<?php

require_once __DIR__ . '/../autoRequireClass.php';

class PurchaseDAO extends ClassDAO
{
    private Purchase $purchase;

    public function __construct(Purchase $purchase, ConnectionDB $connectionDB)
    {
        $this->purchase = $purchase;
        parent::__construct($connectionDB);
    }

    public function deletePurchase(): bool
    {
        try {
            $id = $this->getPurchase()->getId();

            $pdo = $this->getConnectionDB()->getConnection();

            $sql = "DELETE FROM purchases WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao deletar compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function editPurchase(): bool
    {
        try {
            $id = $this->getPurchase()->getId();
            $name = $this->getPurchase()->getName();
            $maxSpend = $this->getPurchase()->getMaxSpend();
    
            $pdo = $this->getConnectionDB()->getConnection();

            $sql = "UPDATE purchases SET name = :name, max_spend = :maxSpend WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':name', $name);
            $query->bindValue(':maxSpend', $maxSpend);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao editar compra de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function getPurchase(): Purchase
    {
        return $this->purchase;
    }

    public function registerPurchase(): bool
    {
        try {
            $idUser = $this->getPurchase()->getIdUser();
            $name = $this->getPurchase()->getName();
            $maxSpend = $this->getPurchase()->getMaxSpend();
    
            $pdo = $this->getConnectionDB()->getConnection();
        
            $sql = "INSERT INTO purchases (id_user, name, max_spend) VALUES (:idUser, :name, :maxSpend)";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':idUser', $idUser);
            $query->bindValue(':name', $name);
            $query->bindValue(':maxSpend', $maxSpend);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao criar compra: " . $exc->getMessage());
            return false;
        }
    }

    public function searchPurchaseById(): bool | array
    {
        try {
            $id = $this->getPurchase()->getId();

            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql = "SELECT * FROM purchases WHERE id = :id LIMIT 1";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
    
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            error_log("Erro ao buscar compras de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function searchPurchasesByIdUser(): bool | array
    {
        try {
            $idUser = $this->getPurchase()->getIdUser();

            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql = "SELECT * FROM purchases WHERE id_user = :idUser ORDER BY name ASC";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':idUser', $idUser);
            $query->execute();
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result ?: [];
        } catch (PDOException $exc) {
            error_log("Erro ao buscar compras de usuário: " . $exc->getMessage());
            return false;
        }
    }
}