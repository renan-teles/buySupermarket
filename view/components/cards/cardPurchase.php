<?php

function getCardPurchase(array $purchase): string
{
    $id = $purchase['id'];
    $name = $purchase['name'];
    $maxSpend = $purchase['max_spend'];
    $finalValue = $purchase['total_value'];
    $totalItems = $purchase['total_items'];

    $component = "
    <div id='card_$id' class='card shadow-sm'>
        <div class='col-12 d-flex justify-content-center mt-3'>
            <div class='col-4'>
                <img src='../assets/img/img_kartPurchase.png' class='card-img-top' alt='Carrinho de Compra'>
            </div>
        </div>
        <div class='card-body text-center'>
            <h5 id='purchaseName' class='card-title'>$name</h5>
            <div class='mb-3'>
                <span class='card-text'>Gasto Máximo: <strong id='purchaseMaxSpend'>". number_format($maxSpend, 2, ',', '.') ."</strong> R$</span><br>
                <span class='card-text'>Gasto Atual: <strong>". number_format($finalValue, 2, ',', '.') ."</strong> R$</span><br>
                <span class='card-text'>Quant. Items: <strong>$totalItems</strong></span><br>
            </div>
            <div class='btn-group' role='group'>
                <button type='button' class='btn btn-primary dropdown-toggle mb-2' data-bs-toggle='dropdown' aria-expanded='false'>
                    <i class='bi-basket me-2'></i>Compra
                </button>
                <ul class='dropdown-menu text-center'>
                    <li><button id='card_$id' class='btn btnModalEditPurchase' type='button' data-bs-target='#modalEditPuchase' data-bs-toggle='modal'><i class='bi-pencil me-1'></i>Editar Compra</button></li>
                    <li><button id='card_$id' class='btn text-danger btnModalDeletePurchase' type='button' data-bs-target='#modalDeletePuchase' data-bs-toggle='modal'><i class='bi-trash me-1'></i>Excluir Compra</button></li>
                </ul>
            </div>
            <form action='./current-purchase.php' method='POST'>
                <input type='hidden' name='purchase_id' value='". $id ."'/>
                <button class='btn btn-success mb-2' type='submit'><i class='bi-bar-chart-steps me-2'></i>Gerir Items</button>
            </form>
        </div>
    </div>
    ";
    return $component;
}
