<?php

require_once __DIR__ . '/../autoRequireClass.php';

class DeleteUser implements ActionUser
{
    public function execute(UserDAO $userDAO): void
    {
        //Query
        $status = $userDAO->deleteUser();   
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível deletar a conta."]; 
            header('Location: ../view/pages/panel-user.php');
            return;
        }

        //Response
        header("Location: ./controlUser.php?act=logout-user");
    }
}