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
    'delete-item',
    'edit-item',
    'register-item'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames))
{
    $_SESSION['msg-errors'] = ["Ação inválida!"]; 
    header('Location: ../view/pages/current-purchase.php');
    exit;
}

//Get Form Data Item
$nameItem = isset($_POST['name_item'])? $_POST['name_item'] : '';
$unitMeasurement = isset($_POST['unit_measurement_item'])? intval($_POST['unit_measurement_item']) : 0;
$quantity = isset($_POST['quantity_item'])? floatval(str_replace(',','.', str_replace('.', '', $_POST['quantity_item']))) : 0;
$price = isset($_POST['price_item'])? floatval(str_replace(',','.', str_replace('.', '', $_POST['price_item']))) : 0;

//Get and Verify Data User
$userData = isset($_SESSION['userData'])? $_SESSION['userData'] : null;
if(!$userData)
{
    session_destroy();
    header('Location: ../index.php');
    exit;
}

//Get and Verify Purchase ID Item
$purchaseID = isset($_SESSION['currentPurchaseData'])? $_SESSION['currentPurchaseData']['id'] : null;
if(!$purchaseID)
{
    $_SESSION['msg-errors'] = ["Ação não realizada! O id da compra não foi encontrado."]; 
    header('Location: ../view/pages/current-purchase.php');
    exit;
}

//Create Object Purchase Item
$purchaseItem = new PurchaseItem($purchaseID, $unitMeasurement, $nameItem, $quantity, $price);

//Get and Verify Item Id
$itemID = isset($_POST['item_id'])? intval($_POST['item_id']) : null;   
if($action !== 'register-item')
{
    if(!$itemID)
    {
        $_SESSION['msg-errors'] = ["Ação não realizada! O id do item não foi encontrado."]; 
        header('Location: ../view/pages/current-purchase.php');
        exit;
    }

    //Set Item ID
    $purchaseItem->setId($itemID);
}

//Create Object DAO Item
$purchaseItemDAO = new PurchaseItemDAO($purchaseItem, $connectionDB);

//Actions
$actionsItem = array(
    $actionsNames[0] => new DeletePurchaseItem(),
    $actionsNames[1] => new EditPurchaseItem(),
    $actionsNames[2] => new RegisterPurchaseItem()
);

//Execute Action
$actionsItem[$action]->execute($purchaseItemDAO);