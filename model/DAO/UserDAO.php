<?php

require_once __DIR__ . '/../autoRequireClass.php';

class UserDAO extends ClassDAO
{
    private User $user;

    public function __construct(User $user, ConnectionDB $connectionDB)
    {
        $this->user = $user;
        parent::__construct($connectionDB);
    }

    public function deleteUser(): bool
    {
        try {
            $id = $this->getUser()->getId();

            $pdo = $this->getConnectionDB()->getConnection();

            $sql = "DELETE FROM users WHERE id = :id";
    
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao deletar usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function editPasswordUser(): bool
    {
        try {
            $id = $this->getUser()->getId();
            $passwordHash = password_hash($this->getUser()->getNewPassword(), PASSWORD_DEFAULT);
    
            $pdo = $this->getConnectionDB()->getConnection();
        
            $sql = "UPDATE users SET password = :password WHERE id = :id";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':password', $passwordHash);
    
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao editar senha de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function editNameAndEmailUser(): bool
    {
        try {
            $id = $this->getUser()->getId();
            $name = $this->getUser()->getName();
            $email = $this->getUser()->getEmail();

            $pdo = $this->getConnectionDB()->getConnection();
        
            $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);

            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao editar nome e email de usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function registerUser(): bool
    {
        try {
            $name = $this->getUser()->getName();
            $email = $this->getUser()->getEmail();
            $passwordHash = password_hash($this->getUser()->getPassword(), PASSWORD_DEFAULT);
    
            $pdo = $this->getConnectionDB()->getConnection();
        
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        
            $query = $pdo->prepare($sql);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $passwordHash);
    
            $query->execute();
    
            return $query->rowCount() > 0;
        } catch (PDOException $exc) {
            error_log("Erro ao registrar usuário: " . $exc->getMessage());
            return false;
        }
    }

    public function searchUserByEmail(bool $getPassword): bool | array
    {
        try {
            $email = $this->getUser()->getEmail();
        
            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql =
                $getPassword
                    ? "SELECT * FROM users WHERE email = :email LIMIT 1" 
                    : "SELECT id, name, email FROM users WHERE email = :email LIMIT 1";
       
            $query = $pdo->prepare($sql);
            $query->bindValue(':email', $email);

            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            error_log("Erro ao buscar usuário por email: " . $exc->getMessage());
            return false;
        }
    }
    
    public function searchUserById(bool $getPassword): bool | array
    {
        try {
            $id = $this->getUser()->getId();
        
            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql =
                $getPassword
                    ? "SELECT * FROM users WHERE id = :id LIMIT 1" 
                    : "SELECT id, name, email FROM users WHERE id = :id LIMIT 1";
       
            $query = $pdo->prepare($sql);
            $query->bindValue(':id', $id);

            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            error_log("Erro ao buscar usuário por id: " . $exc->getMessage());
            return false;
        }
    }

    public function verifyExistsUserByEmail(): bool | array
    {
        try {
            $email = $this->getUser()->getEmail();
        
            $pdo = $this->getConnectionDB()->getConnection();
    
            $sql = "SELECT 1 FROM users WHERE email = :email LIMIT 1";
       
            $query = $pdo->prepare($sql);
            $query->bindValue(':email', $email);

            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            return $result ?: []; 
        } catch (PDOException $exc) {
            error_log("Erro ao buscar usuário por email: " . $exc->getMessage());
            return false;
        }
    }
}