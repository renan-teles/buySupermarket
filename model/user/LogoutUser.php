<?php

require_once __DIR__ . '/../autoRequireClass.php';

class LogoutUser implements ActionUser
{
    public function execute(UserDAO $userDAO): void
    {
        session_destroy();
        header('Location: ../index.php');
    }
}