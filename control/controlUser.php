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
$name = filter_input(INPUT_POST, 'name_user', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$email = filter_input(INPUT_POST, 'email_user', FILTER_VALIDATE_EMAIL) ?? '';
$password = filter_input(INPUT_POST, 'password_user', FILTER_DEFAULT) ?? '';
$newPassword = filter_input(INPUT_POST, 'new_password_user', FILTER_DEFAULT) ?? '';

//Create User Object 
$user = new User($name, $email, $password, $newPassword);

//Get and Verify User ID
if($action !== 'register-user' && $action !== 'login-user')
{
    $userData = $_SESSION['userData'] ?? null;
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