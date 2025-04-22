<?php

require_once __DIR__ . '/../autoRequireClass.php';

class LoginUser implements ActionUser
{
    public function execute(UserDAO $userDAO): void
    {
        //Validate Form Data User
        $errors = [];
        if (!validateEmail($userDAO->getUser()->getEmail())) 
        {
            $errors[] = "E-mail inválido!";
        }
        if (!validatePassword($userDAO->getUser()->getPassword())) 
        {
            $errors[] = "Senha inválida!";
        }
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../index.php');
            return;
        }

        //Validate Exist User
        $userDB = $userDAO->searchUserByEmail(true);
        if($userDB === false)
        {
            $_SESSION['msg-errors'] = ["Erro ao buscar usuário!"]; 
            header('Location: ../index.php');
            return;
        }
        if($userDB === [])
        {
            $_SESSION['msg-errors'] = ["Usuário não encontrado!"]; 
            header('Location: ../index.php');
            return;
        }

        $passwordForm = $userDAO->getUser()->getPassword();
        $passwordDB = $userDB['password'];

        //Validate password
        if(!password_verify($passwordForm, $passwordDB))
        {
            $_SESSION['msg-errors'] = ["Senha inválida ou incorreta!"]; 
            header('Location: ../index.php');
            return;
        }

        //Response
        $_SESSION['userData'] = array('id' => intval($userDB['id']), 'name' => $userDB['name'], 'email' => $userDB['email']);
        header('Location: ../view/pages/my-purchases.php');
    }
}