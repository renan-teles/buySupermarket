<?php

require_once __DIR__ . '/../autoRequireClass.php';

class EditPurchaseItem implements ActionPurchaseItem
{
    public function execute(PurchaseItemDAO $purchaseItemDAO): void
    {
        //Validate Form Data Item
        $errors = [];
        if (empty($purchaseItemDAO->getPurchaseItem()->getName())) 
        {
            $errors[] = "O campo nome precisa estar preechido!";
        }
        if(empty($purchaseItemDAO->getPurchaseItem()->getIdUnit()) || $purchaseItemDAO->getPurchaseItem()->getIdUnit() <= 0)
        {
            $errors[] = "O campo unidade de medida do item precisa estar preechido corretamente!";
        }
        if(empty($purchaseItemDAO->getPurchaseItem()->getQuantity()) || $purchaseItemDAO->getPurchaseItem()->getQuantity() <= 0)
        {
            $errors[] = "O campo quantidade do item precisa estar preechido corretamente!";
        }
        if (empty($purchaseItemDAO->getPurchaseItem()->getPrice()) || $purchaseItemDAO->getPurchaseItem()->getPrice() <= 0) 
        {
           $errors[] = "O campo preço do item precisa estar preechido!";
        } 
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../view/pages/current-purchase.php');
            return;
        }
    
        //Query
        $status = $purchaseItemDAO->editPurchaseItem();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível editar o item."]; 
            header('Location: ../view/pages/current-purchase.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Item editado com sucesso!"; 
        header('Location: ../view/pages/current-purchase.php');
    }
}
