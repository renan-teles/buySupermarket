<?php

class User 
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $newPassword;

    public function __construct(string $name, string $email, string $password, string $newPassword) 
    {
        $this->id = 0;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->newPassword = $newPassword;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }
}
