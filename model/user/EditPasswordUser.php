<?php

require_once __DIR__ . '/../autoRequireClass.php';

class EditPasswordUser implements ActionUser
{
    public function execute(UserDAO $userDAO): void
    {
        //Validate Form Data User
        $errors = [];
        if (!validatePassword($userDAO->getUser()->getPassword())) 
        {
            $errors[] = "Senha atual inválida!";
        }
        if (!validatePassword($userDAO->getUser()->getNewPassword())) 
        {
            $errors[] = "Nova senha inválida!";
        }
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../view/pages/panel-user.php');
            return;
        }

        $oldPasswordForm = $userDAO->getUser()->getPassword();
        $newPasswordForm = $userDAO->getUser()->getNewPassword();
        
        //Search Password User
        $userDB = $userDAO->searchUserById(true);

        if($userDB === false)
        {
            $_SESSION['msg-errors'] = ['Erro ao buscar dados de usuário!'];
            header('Location: ../view/pages/panel-user.php');
            return;
        }
        if($userDB === [])
        { 
            session_destroy();
            header('Location: ../index.php');
            return;
        }

        $passwordDB = $userDB['password'];

        //Validate Password
        if(!password_verify($oldPasswordForm, $passwordDB))
        {
            $_SESSION['msg-errors'] = ["Senha atual incorreta!"]; 
            header('Location: ../view/pages/panel-user.php');
            return;
        }

        //Query
        $status = $userDAO->editPasswordUser();      
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível alterar a senha."]; 
            header('Location: ../view/pages/panel-user.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Senha atualizada com sucesso!"; 
        header('Location: ../view/pages/panel-user.php');
    }
}