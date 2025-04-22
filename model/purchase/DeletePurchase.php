<?php

require_once __DIR__ . '/../autoRequireClass.php';

class DeletePurchase implements ActionPurchase
{
    public function execute(PurchaseDAO $purchaseDAO): void
    {
        //Query
        $status = $purchaseDAO->deletePurchase();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível deletar a compra."]; 
            header('Location: ../view/pages/my-purchases.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Compra excluída com sucesso!"; 
        header("Location: ../view/pages/my-purchases.php");
    }
}
