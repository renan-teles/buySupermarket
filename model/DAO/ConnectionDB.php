<?php

require_once __DIR__ . '/../autoRequireClass.php';

class ConnectionDB implements DatabaseConnection
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getThisConn()
    {
        return $this->connection;
    }

    public function connect(): void
    {
        $this->getThisConn()->connect();
    }

    public function getConnection()
    {
        return $this->getThisConn()->getConnection();
    }
}
