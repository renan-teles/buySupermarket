<?php   

function getTr(array $item, bool $showBtns): string
{
    $id = $item['id'];
    $name = $item['name'];
    $quantity = $item['quantity'];
    $unit_measurement = $item['unit_measurement'];
    $isUnit = $unit_measurement === 'unidade';
    $classBtns = $showBtns? '' : 'd-none'; 

    $component = "
        <tr id='tr_$id' class='tr-item'>
            <input id='unit_measurement_item_list' value='" . ($isUnit? 1 : 2) . "' type='hidden'>
            <td id='itemListName' scope='row' class='tr-title'>$name</td>
            <td id='itemListQuantity'>". ($isUnit? number_format($quantity, 0, ',','.') : number_format($quantity, 2, ',','.'))  ." </td>
            <td id='itemListUnitMeasurement'>".  $unit_measurement ."</td>
            <td class='". $classBtns ."'>
                <button id='tr_$id' class='btn btn-secondary btn-sm mb-2 mb-md-0 btnModalEditItemList' data-bs-target='#modalEditItemList'  data-bs-toggle='modal'><i class='bi-pencil'></i></button>
                <button id='tr_$id' class='btn btn-danger btn-sm mb-2 mb-md-0 btnModalDeleteItemList' data-bs-target='#modalDeleteItemList' data-bs-toggle='modal'><i class='bi-trash'></i></button>
            </td>
        </tr>
    ";
    return $component;
}