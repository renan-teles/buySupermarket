<?php

interface ActionPlannedPurchaseItem
{
    public function execute(PlannedPurchaseItemDAO $plannedPurchaseItemDAO): void;
}