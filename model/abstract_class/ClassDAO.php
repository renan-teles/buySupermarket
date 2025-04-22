<?php

abstract class ClassDAO
{
    private ConnectionDB $connectionDB;

    public function __construct(ConnectionDB $connectionDB)
    {
        $this->connectionDB = $connectionDB;
    }

    public function getConnectionDB(): ConnectionDB
    {
        return $this->connectionDB;
    }
}