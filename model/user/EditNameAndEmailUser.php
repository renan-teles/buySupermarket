<?php

require_once __DIR__ . '/../autoRequireClass.php';

class EditNameAndEmailUser implements ActionUser
{
    public function execute(UserDAO $userDAO): void
    {
        //Validate Form Data User
        $errors = [];
        if (!validateName($userDAO->getUser()->getName())) 
        {
            $errors[] = "Nome inválido!";
        }
        if (!validateEmail($userDAO->getUser()->getEmail())) 
        {
            $errors[] = "E-mail inválido!";
        }
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../view/pages/panel-user.php');
            return;
        }

        //Query
        $status = $userDAO->editNameAndEmailUser();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível editar o usuário."]; 
            header('Location: ../view/pages/panel-user.php');
            return;
        }
        
        //Response
        $_SESSION['msg-success'] = "Usuário atualizado com sucesso!"; 
        header('Location: ./controlUser.php?act=get-user');
    }
}