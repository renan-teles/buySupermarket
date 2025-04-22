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
    'delete-item-list',
    'edit-item-list',
    'register-item-list'
];

//Validate Curret Action
if(!validateAction($action, $actionsNames))
{
    $_SESSION['msg-errors'] = ["Ação inválida!"]; 
    header('Location: ../view/pages/list-current-purchase.php');
    exit;
}

//Get Form Data Item
$nameItem = isset($_POST['name_item_list'])? $_POST['name_item_list'] : '';
$unitMeasurement = isset($_POST['unit_measurement_item_list'])? intval($_POST['unit_measurement_item_list']) : 0;
$quantity = isset($_POST['quantity_item_list'])? floatval(str_replace(',','.', str_replace('.', '', $_POST['quantity_item_list']))) : 0;

//Get and Verify Data User
$userData = isset($_SESSION['userData'])? $_SESSION['userData'] : null;
if(!$userData)
{
    session_destroy();
    header('Location: ../index.php');
    exit;
}

//Get and Verify Purchase ID item
$purchaseID = isset($_SESSION['currentPurchaseData'])? $_SESSION['currentPurchaseData']['id'] : null;
if(!$purchaseID)
{
    $_SESSION['msg-errors'] = ["Ação não realizada! O id da compra não foi encontrado."]; 
    header('Location: ../view/pages/my-purchases.php');
    exit;
}

//Create Object Purchase
$plannedPurchaseItemForm = new PlannedPurchaseItem($purchaseID, $unitMeasurement, $nameItem , $quantity);

//Get and Verify Item Id
if($action !== 'register-item-list')
{
    $itemID = isset($_POST['item_list_id'])? $_POST['item_list_id'] : null; 
    if(!$itemID)
    {
        $_SESSION['msg-errors'] = ["Ação não realizada! O id do item não foi encontrado."]; 
        header('Location: ../view/pages/list-current-purchase.php');
        exit;
    }

    //Set Item ID
    $plannedPurchaseItemForm->setId($itemID);
}

//Create Object DAO Item
$plannedPurchaseItemDAO = new PlannedPurchaseItemDAO($plannedPurchaseItemForm, $connectionDB);

//Actions
$actionsItem = array(
    $actionsNames[0] => new DeletePlannedPurchaseItem(),
    $actionsNames[1] => new EditPlannedPurchaseItem(),
    $actionsNames[2] => new RegisterPlannedPurchaseItem()
);

//Execute Action
$actionsItem[$action]->execute($plannedPurchaseItemDAO);