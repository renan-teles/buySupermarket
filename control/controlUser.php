<html>
    <head>
        <title>Redirecionando...</title>
        <link rel="icon" href="../view/assets/img/logo_bs.png" type="image/png">
    </head>
</html>

<?php
session_start();

//Connection to Database
require_once '../model/DAO/ConnectionToDatabase.php';

//Requires
require_once __DIR__ . '/../model/autoRequireClass.php';
require_once './validateFunctions.php';

//Get Action
$action = isset($_GET['act'])? $_GET['act'] : '';

//Names Actions
$actionsNames = 
[
    'delete-user',
    'edit-name-and-email-user',
    'edit-password-user', 
    'get-user',
    'login-user',
    'logout-user',
    'register-user'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames))
{
    session_destroy();
    header('Location: ../index.php');
    exit;
}

//Get Form Data User
$name = isset($_POST['name_user'])? $_POST['name_user'] : '';
$email = isset($_POST['email_user'])? filter_var($_POST['email_user'], FILTER_SANITIZE_EMAIL) : '';
$password = isset($_POST['password_user'])? $_POST['password_user'] : '';
$newPassword = isset($_POST['new_password_user'])? $_POST['new_password_user'] : '';

//Create User Object 
$user = new User($name, $email, $password, $newPassword);

//Get and Verify User ID
if($action !== 'register-user' && $action !== 'login-user')
{
    $userData = isset($_SESSION['userData'])? $_SESSION['userData'] : null;
    if(!$userData)
    {
        session_destroy();
        header('Location: ../index.php');
        exit;
    }

    //Set User ID
    $user->setId($userData['id']);
}

//Create DAO Object User
$userDAO = new UserDAO($user, $connectionDB);

//Actions
$actionsUser = array(
    $actionsNames[0] => new DeleteUser(),
    $actionsNames[1] => new EditNameAndEmailUser(),
    $actionsNames[2] => new EditPasswordUser(),
    $actionsNames[3] => new GetUser(),
    $actionsNames[4] => new LoginUser(),
    $actionsNames[5] => new LogoutUser(),
    $actionsNames[6] => new RegisterUser()
);

//Execute Action
$actionsUser[$action]->execute($userDAO);