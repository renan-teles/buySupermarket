<?php

function getCardItem(array $item): string
{
    $id = $item['id'];
    $name = $item['name'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $unit_measurement = $item['unit_measurement'];
    $totalValue = $quantity * $price;
    $isUnit = $unit_measurement === 'unidade';

    $component = "
    <div id='card_$id' class='card h-100 shadow-sm'>
        <input id='unit_measurement_item' type='hidden' value=". ($isUnit? 1 : 2)  ." />
        <div class='text-center mt-3'>
            <img src='../assets/img/img_itemsPurchase.png' class='card-img-top' alt='Sacola de Compra' style='width: 90px;'>
        </div>
        <div class='card-body text-center d-flex flex-column justify-content-between'>
            <div>
                <h5 id='itemName' class='card-title'>$name</h5>
                <div>
                    <span class='card-text'>Quant.: <strong id='itemQuantity'>". ($isUnit? number_format($quantity, '0', ',','.') : number_format($quantity, '2', ',','.')) ."</strong>" . ($isUnit? '' : ' Kg') ."</span>
                </div>
                <div>
                    <span class='card-text'>Preço: <strong id='itemPrice'>". number_format($price, '2', ',','.') ."</strong> R$</span>
                </div>
                <div>
                    <span class='card-text'>Total: <strong>". number_format($totalValue, '2',',','.') ."</strong> R$</span>
                </div>
            </div>
            <div class='mt-3'>
                <button id='card_$id' class='btn btn-danger mb-1 btnModalDeleteItem' type='button' data-bs-target='#modalDeleteItem' data-bs-toggle='modal'>
                    <i class='bi-trash me-1'></i>Remover
                </button>
                <button id='card_$id' class='btn btn-secondary mb-1 btnModalEditItem' type='button' data-bs-target='#modalEditItem' data-bs-toggle='modal'>
                    <i class='bi-pencil me-1'></i>Editar
                </button>
            </div>
        </div>
    </div>";
    return $component;
}
