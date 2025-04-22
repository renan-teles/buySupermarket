<?php

require_once __DIR__ . '/../autoRequireClass.php';

class PDOConnection implements DatabaseConnection
{
    private string $dns;
    private string $user;
    private string $pass;
    private PDO $pdo;

    public function __construct(string $dns, string $user, string $pass)
    {
        $this->dns = $dns;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function getDns(): string
    {
        return $this->dns;
    }

    public function getUser(): string
    {
        return $this->user;
    }
    
    public function getPass(): string
    {
        return $this->pass;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function connect(): void
    {
        try {
            $pdo = new PDO($this->getDns(), $this->getUser(), $this->getPass());
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (PDOException $exc) {
            error_log("Erro realizar a conexão com o banco de dados: " . $exc->getMessage());
            session_destroy();
            session_start();
            $_SESSION['msg-errors'] = ['Não foi possível realizar a conexão com o Banco de Dados :('];
            header('Location: ../index.php');
            exit;
        }
    }
}
