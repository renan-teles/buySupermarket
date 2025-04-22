<?php

interface ActionPurchase
{
    public function execute(PurchaseDAO $purchaseDAO): void;
}