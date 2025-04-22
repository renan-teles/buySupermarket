<?php

interface ActionPurchaseItem
{
    public function execute(PurchaseItemDAO $purchaseItemDAO): void;
}
