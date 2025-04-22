<?php

require_once __DIR__ . '/../autoRequireClass.php';

class GetUser implements ActionUser
{
    public function execute(UserDAO $userDAO): void
    {
        $userDB = $userDAO->searchUserById(false);
        if(!$userDB)
        {
            session_destroy();
            header('Location: ../index.php');
            return;
        }
        $_SESSION['userData'] = $userDB;
        header('Location: ../view/pages/panel-user.php');
    }
}