<?php

require_once __DIR__ . '/../autoRequireClass.php';

class DeletePurchaseItem implements ActionPurchaseItem
{
    public function execute(PurchaseItemDAO $purchaseItemDAO): void
    {
        //Query
        $status = $purchaseItemDAO->deletePurchaseItem();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível deletar o item."]; 
            header('Location: ../view/pages/current-purchase.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Item deletada com sucesso!"; 
        header("Location: ../view/pages/current-purchase.php");
    }
}
