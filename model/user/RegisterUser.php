<?php

require_once __DIR__ . '/../autoRequireClass.php';

class RegisterUser implements ActionUser
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
        if (!validatePassword($userDAO->getUser()->getPassword())) 
        {
            $errors[] = "Senha inválida!";
        }
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../view/pages/register-user.php');
            return;
        }
    
        //Verify Exist User
        $userDB = $userDAO->verifyExistsUserByEmail();
        if($userDB === false)
        {
            $_SESSION['msg-errors'] = ["Erro ao fazer verificação da existência de usuário!"]; 
            header('Location: ../view/pages/register-user.php');
            return;
        }
        if($userDB)
        {
            $_SESSION['msg-errors'] = ["Usuário já cadastrado com o email digitado!"]; 
            header('Location: ../view/pages/register-user.php');
            return;
        }
    
        //Query
        $status = $userDAO->registerUser();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível cadastrar o usuário."]; 
            header('Location: ../view/pages/register-user.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Conta criada com sucesso!"; 
        header('Location: ../index.php');
    }
}