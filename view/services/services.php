<?php

require_once __DIR__ . '/../../model/autoRequireClass.php';

function getUserPurchases(int $userId, ConnectionDB $connectionDB): bool | array
{
    //Instances
    $purchase = new Purchase('', 0, $userId);
    $purchaseDAO = new PurchaseDAO($purchase, $connectionDB);
    return $purchaseDAO->searchPurchasesByIdUser();
}

function getCurrentPurchase(int $purchaseId, ConnectionDB $connectionDB): bool | array
{
    //Instances
    $purchase = new Purchase('', 0, 0);
    $purchase->setId($purchaseId);
    $purchaseDAO = new PurchaseDAO($purchase, $connectionDB);
    return $purchaseDAO->searchPurchaseById();
}

function getPurchaseItems(int $purchaseId, ConnectionDB $connectionDB): bool | array
{
    //Instances
    $purchaseItem = new PurchaseItem($purchaseId, 0, '', 0, 0);
    $purchaseItemDAO = new PurchaseItemDAO($purchaseItem, $connectionDB);
    return $purchaseItemDAO->searchPurchaseItemsByIdPurchase();
}

function getPlannedPurchaseItems(int $purchaseID, ConnectionDB $connectionDB): bool | array
{
    //Instances
    $plannedPurchaseItem = new PlannedPurchaseItem($purchaseID, 0, '', 0);
    $plannedPurchaseItemDAO = new PlannedPurchaseItemDAO($plannedPurchaseItem, $connectionDB);
    return $plannedPurchaseItemDAO->searchPlannedPurchaseItemsByIdPurchase();
}