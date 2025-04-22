<?php

require_once __DIR__ . '/../autoRequireClass.php';

class RegisterPlannedPurchaseItem implements ActionPlannedPurchaseItem
{
    public function execute(PlannedPurchaseItemDAO $plannedPurchaseItemDAO): void
    {
        //Validate Form Data Item
        $errors = [];
        if (empty($plannedPurchaseItemDAO->getPlannedPurchaseItem()->getName())) 
        {
            $errors[] = "O campo nome precisa estar preechido!";
        }
        if(empty($plannedPurchaseItemDAO->getPlannedPurchaseItem()->getIdUnit()) || $plannedPurchaseItemDAO->getPlannedPurchaseItem()->getIdUnit() <= 0)
        {
            $errors[] = "O campo unidade de medida do item precisa estar preechido corretamente!";
        }
        if(empty($plannedPurchaseItemDAO->getPlannedPurchaseItem()->getQuantity()) || $plannedPurchaseItemDAO->getPlannedPurchaseItem()->getQuantity() <= 0)
        {
            $errors[] = "O campo quantidade do item precisa estar preechido corretamente!";
        }
        if (!empty($errors)) 
        {
            $_SESSION['msg-errors'] = $errors;
            header('Location: ../view/pages/list-current-purchase.php');
            return;
        }
    
        //Query
        $status = $plannedPurchaseItemDAO->registerPlannedPurchaseItem();
        if(!$status)
        {
            $_SESSION['msg-errors'] = ["Não foi possível adicionar o item à lista de compra."]; 
            header('Location: ../view/pages/list-current-purchase.php');
            return;
        }

        //Response
        $_SESSION['msg-success'] = "Item adicionado à lista com sucesso!"; 
        header("Location: ../view/pages/list-current-purchase.php");
    }
}