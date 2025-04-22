<?php
    session_start();

    //Validate Login
    require_once '../../control/validateFunctions.php';
    validateLogin();

    //Conncetion to Database
    require_once '../../model/DAO/connectionToDatabase.php';

    //Require Services
    require_once '../services/services.php';

    //Verify Current Purchase Data
    if(!isset($_SESSION['currentPurchaseData']))
    {
        $_SESSION['msg-errors'] = ["Os dados da compra selecionada não foram encontrados!"]; 
        header('Location: ./my-purchases.php');
        exit;
    }

    $itemsList = getPlannedPurchaseItems($_SESSION['currentPurchaseData']['id'], $connectionDB);
    if($itemsList === false)
    {
        $_SESSION['msg-errors'] = ["Erro ao buscar items da lista de compra."]; 
    }

    //Get Name Purchase
    $name = $_SESSION['currentPurchaseData']['name'];

    //Requires Components
    include_once '../components/navs/navbar.php';
    include_once '../components/outhers/tr.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Supermarket</title>
    <link rel="icon" href="../assets/img/logo_bs.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/css_bootstrap/bootstrap.min.css">
</head>
<body class="bg-gray" style="height: 100dvh;">
    <?php echo getNavbar("list-current-purchase"); ?>
    <div class="col-12 p-5"></div>
    <div>
        <main class="container-md pb-5">
            <div class="col-12 bg-light rounded shadow-sm p-4">
                <div class="row mb-3">
                    <div class="col-12 col-md text-center text-md-start">
                       <h4><i class="bi-card-list me-2"></i><?=$name;?> - Lista de Items</h4>
                    </div>
                    <div class="col-12 col-md text-center text-md-end mt-2 mt-md-0">
                        <a href="./current-purchase.php" class="btn text-danger mb-2 mb-md-0"><i class='bi-arrow-left-circle-fill me-1'></i>Voltar</a>   
                        <button class="btn btn-primary mb-2 mb-md-0" type="button" data-bs-target="#modalAddItemList" data-bs-toggle="modal">
                           <i class="bi-plus-circle me-1"></i>Adicionar Item
                        </button>
                    </div>
                </div>
                <div id="divSearch" class="input-group sticky-top">
                    <input type="search" id='searchInput' class="form-control" placeholder="Pesquisar Item da Lista...">
                    <button class="btn btn-primary" type="button" id="button-addon2"><i class='bi-search me-1'></i></button>
                </div>
                <div class="col-12"><hr /></div>
                <div class="col-12">
                    <div class="col-12"><?php showMessage(); ?></div>
                    
                    <!--TABLE HERE!-->
                    <div class="table-responsive">
                        <table class="table table-sm text-center table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Unidade de Medida</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if($itemsList)
                                {
                                    foreach ($itemsList as $i) { echo getTr($i, true); } 
                                } else {
                                    echo "<h5 class='mb-3'>Você não possui itens nesta lista.</h5>";
                                }
                            ?>
                            </tbody>
                        </table>                    
                    </div>
                
                </div>
            </div>
        </main>
    </div>
    <button id="btnTop" class="btn bg-light shadow-sm text-primary px-3 fs-2"><i class="bi-arrow-bar-up"></i></button>
    <!-- MODAL ADD -->
    <div class="modal fade" id="modalAddItemList" aria-hidden="true" aria-labelledby="modalAddItemListLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalAddItemListLabel"><i class='bi-plus-circle me-1'></i>Adicionar Item à Lista</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='formAddItemList' method='POST' action='../../control/controlPlannedPurchaseItem.php?act=register-item-list'>
                    <div class='modal-body'>
                        <div class='mb-3'>
                            <label class='form-label'>Nome:</label>
                            <input type='text' name='name_item_list' class='form-control' placeholder='Digite o nome do item...'>
                            <span class='form-text text-danger d-none spanformAddItemList'>O campo nome é obrigatório!</span>
                        </div>

                        <div class='mb-3'>
                            <label class='form-label'>Unidade de Medida:</label>
                            <div class='form-check'>
                                <input class='form-check-input' value='1' type='radio' name='unit_measurement_item_list' id='unitItem' checked>
                                <label class='form-check-label' for='unitItem'>Unidade (Un.)</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' value='2' type='radio' name='unit_measurement_item_list' id='kgItem'>
                                <label class='form-check-label' for='kgItem'>quilograma (Kg)</label>
                            </div>
                        </div>

                        <div class='mb-3'>
                            <label id="label-quantity" class='form-label'>Quantidade de Unidades:</label>
                            <div class='input-group'>
                                <input type='text' name='quantity_item_list' placeholder='Digite o preço por unidade do item...' class='form-control'>
                                <span id="spanItemListQuantityInfo" class='input-group-text'>Un.</span>
                            </div>
                            <span id='spanItemListQuantityAlert' class='form-text text-danger d-none spanformAddItemList'>O campo quantidade de unidades é obrigatório!</span>
                        </div>

                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Adicionar Item à Lista</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEditItemList" aria-hidden="true" aria-labelledby="modalEditItemListLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalEditItemListLabel"><i class='bi-pencil me-1'></i>Editar Item</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='formEditItemList' method='POST' action='../../control/controlPlannedPurchaseItem.php?act=edit-item-list'>
                    <div class='modal-body'>
                        <input id='itemListIdEdit' type='hidden' name='item_list_id' />
                        <div class='mb-3'>
                            <label class='form-label'>Nome:</label>
                            <input type='text' name='name_item_list' class='form-control' placeholder='Digite o nome do item...'>
                            <span class='form-text text-danger d-none spanFormEditItemList'>O campo nome é obrigatório!</span>
                        </div>
                        <div class='mb-3'>
                            <label class='form-label'>Unidade de Medida:</label>
                            <div class='form-check'>
                                <input class='form-check-input' value='1' type='radio' name='unit_measurement_item_list' id='naoPerecivelEdit'>
                                <label class='form-check-label' for='naoPerecivelEdit'>Unidade (Un.)</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' value='2' type='radio' name='unit_measurement_item_list' id='perecivelEdit'>
                                <label class='form-check-label' for='perecivelEdit'>quilograma (Kg)</label>
                            </div>
                        </div>
                        <div class='mb-3'>
                            <label id="label-edit-quantity" class='form-label'>Quantidade de Unidades:</label>
                            <div class='input-group'>
                                <input type='text' name='quantity_item_list' placeholder='Digite a quantidade do item...' class='form-control'>
                                <span id="spanItemListEditQuantityInfo" class='input-group-text'>Un.</span>
                            </div>
                            <span id='spanItemListEditQuantityAlert' class='form-text text-danger d-none spanFormEditItemList'>O campo quantidade de unidades é obrigatório!</span>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL DELETE -->
    <div class="modal fade" id="modalDeleteItemList" aria-hidden="true" aria-labelledby="modalDeleteItemListLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class='bi-trash me-1'></i>Remover este item da lista?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    
                    <form id="formDeleteItemList" action="../../control/controlPlannedPurchaseItem.php?act=delete-item-list" method="POST">
                        <input id="itemListIdDelete" type="hidden" name="item_list_id" />
                        <button class="btn btn-danger" type="submit">Remover</button>
                    </form>
                
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../../view/assets/js/js_pages/list-current-purchase.js" type="module"></script>
</body>
</html>