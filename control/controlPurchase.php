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
    'delete-purchase',
    'edit-purchase',
    'register-purchase'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames))
{
    $_SESSION['msg-errors'] = ["Ação inválida!"]; 
    header('Location: ../view/pages/my-purchases.php');
    exit;
}

//Get Form Data Purchase
$name = isset($_POST['name_purchase'])? $_POST['name_purchase'] : '';
$maxSpend = isset($_POST['max_spend_purchase'])? floatval(str_replace(',','.', str_replace('.', '', $_POST['max_spend_purchase']))) : 0;

//Get and Verify Data User
$userData = isset($_SESSION['userData'])? $_SESSION['userData'] : null;
if(!$userData)
{
    session_destroy();
    header('Location: ../view/pages/my-purchases.php');
    exit;
}

//Create Purchase Object 
$purchase = new Purchase($name, $maxSpend, $userData['id']);

//Get and Verify Purchase ID
$purchaseID = isset($_POST['purchase_id'])? intval($_POST['purchase_id']) : null;   
if($action !== 'register-purchase')
{
    if(!$purchaseID)
    {
        $_SESSION['msg-errors'] = ["Ação não realizada! O id da compra não foi encontrado."]; 
        header('Location: ../view/pages/my-purchases.php');
        exit;
    }

    //Set Purchase ID
    $purchase->setId($purchaseID);
}

//Create DAO Object Purchase
$purchaseDAO = new PurchaseDAO($purchase, $connectionDB);

//Actions
$actionsPurchase = array(
    $actionsNames[0] => new DeletePurchase(),
    $actionsNames[1] => new EditPurchase(),
    $actionsNames[2] => new RegisterPurchase()
);

//Execute Action
$actionsPurchase[$action]->execute($purchaseDAO);