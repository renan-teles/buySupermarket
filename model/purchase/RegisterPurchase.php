<?php

require_once __DIR__ . '/../autoRequireClass.php';

class RegisterPurchase implements ActionPurchase
{
    public function execute(PurchaseDAO $purchaseDAO): void
    {
        //Validate Form Data Purchase
        $errors = [];
        if (empty($purchaseDAO->getPurchase()->getName())) 
        {
            $errors[] = "O campo nome precisa estar preechido!";
        }
        if (empty($purchaseDAO->getPurchase()->getMaxSpend()) || $purchaseDAO->getPurchase()->getMaxSpend() <= 0) 
        {
            $errors[] = "O campo gasto máximo precisa estar preechido corretamente!";
        }
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../view/pages/my-purchases.php');
            return;
        }
    
        //Query
        $status = $purchaseDAO->registerPurchase();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível criar a compra."]; 
            header('Location: ../view/pages/my-purchases.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Compra criada com sucesso!"; 
        header("Location: ../view/pages/my-purchases.php");
    }
}