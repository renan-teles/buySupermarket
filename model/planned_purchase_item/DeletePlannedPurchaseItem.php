<?php

require_once __DIR__ . '/../autoRequireClass.php';

class DeletePlannedPurchaseItem implements ActionPlannedPurchaseItem
{
    public function execute(PlannedPurchaseItemDAO $plannedPurchaseItemDAO): void
    {
        //Query
        $status = $plannedPurchaseItemDAO->deletePlannedPurchaseItem();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível remover o item da lista."]; 
            header('Location: ../view/pages/list-current-purchase.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Item da lista removido com sucesso!"; 
        header("Location: ../view/pages/list-current-purchase.php");
    }
}
