<?php
    session_start();

    //Validate Login
    require_once '../../control/validateFunctions.php';
    validateLogin();

    //Conncetion to Database
    require_once '../../model/DAO/connectionToDatabase.php';

    //Require Services
    require_once '../services/services.php';
    
    //Get Purchase ID
    $purchaseID = isset($_POST['purchase_id'])? $_POST['purchase_id'] : null;
    if($purchaseID)
    {
        $_SESSION['currentPurchaseData'] = array('id' => intval($purchaseID), 'name' => '');
    }

    //Verify Current Purchase Data
    if(!isset($_SESSION['currentPurchaseData']))
    {
        $_SESSION['msg-errors'] = ["Os dados da compra selecionada não foram encontrados!"]; 
        header('Location: ./my-purchases.php');
        exit;
    }

    //Get Current Purchase
    $currentPurchase = getCurrentPurchase($_SESSION['currentPurchaseData']['id'], $connectionDB);
    if($currentPurchase === false)
    {
        $_SESSION['msg-errors'] = ["Erro ao buscar compra selecionada."]; 
        header('Location: ./my-purchases.php');
        exit;
    }

    //Set Name Current Purchase
    $_SESSION['currentPurchaseData']['name'] = $currentPurchase['name'];

    //Get Purchase Items
    $itemsPurchases = getPurchaseItems($_SESSION['currentPurchaseData']['id'], $connectionDB);
    if($itemsPurchases === false)
    {
        $_SESSION['msg-errors'] = ["Erro ao buscar items da compra."]; 
    }

    //Get Planned Purchase Items
    $itemsList = getPlannedPurchaseItems($_SESSION['currentPurchaseData']['id'], $connectionDB);
    if($itemsList === false)
    {
        $_SESSION['msg-errors'] = ["Erro ao buscar items da lista de compra."]; 
    }

    //Config Vars
    $name = $currentPurchase['name'];
    $maxSpend = $currentPurchase['max_spend'];
    $totalCurrent = $currentPurchase['total_value'];
    $quantItems = $currentPurchase['total_items']; 

    //Require Components
    include_once '../components/navs/navbar.php';   
    include_once '../components/cards/cardItem.php'; 
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
    <div>
        <?php echo getNavbar("current-purchase"); ?>
        <div class="col-12 p-5"></div>
        <main class="container-md pb-5">
            <div class="col-12 p-4 bg-light rounded">
                <div class="row row-cols-1 row row-cols-sm-2">
                    <div class="col">
                        <h3 class='mb-3 text-center text-md-start'><i class="bi-basket me-2"></i><?= $name; ?></h3>
                    </div>
                    <div class="col text-center text-sm-end">
                        <a href="./my-purchases.php" class="btn text-danger mb-3 mb-md-0"><i class='bi-arrow-left-circle-fill me-1'></i>Voltar</a>   
                        <div class='btn-group' role='group'>
                            <button type='button' class='btn btn-primary dropdown-toggle mb-3 mb-md-0' data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='bi-basket me-2'></i>Ações
                            </button>
                            <ul class='dropdown-menu text-center'>
                                <li>
                                    <button class="btn btn text-primary w-100" type="button" data-bs-target="#modalAddItem" data-bs-toggle="modal">
                                        <i class='bi-plus-circle-fill me-1'></i>Adicionar Item
                                    </button>
                                </li>
                                <li>
                                    <button class="btn text-success w-100" type="button" data-bs-target="#modalViewList" data-bs-toggle="modal">
                                        <i class='bi-eye-fill me-1'></i>Ver Lista
                                    </button>
                                </li>
                                <li>
                                    <a href="./list-current-purchase.php" class="btn text-success w-100">
                                        <i class='bi-pencil-square me-2'></i>Gerir Lista
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="accordion mb-3 mb-sm-0" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class='bi-bar-chart-fill me-2'></i>Dados da Compra
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h6>G. Máximo: <strong><?= number_format($maxSpend, '2', ',', '.');?></strong>R$<h6>
                                        <h6>G. Atual: <strong><?= number_format($totalCurrent, '2', ',','.');?></strong>R$<h6>
                                        <h6>Saldo: <strong><span id='balance'><?= number_format($maxSpend - $totalCurrent, '2', ',', '.');?></strong>R$</span><h6>
                                        <h6 class='mb-3'>Quant. Items: <strong><?= $quantItems; ?></strong><h6> 
                                        <span class="form-text">G.: Gasto | Quant.: Quantidade</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="divSearch" class="input-group mb-3 sticky-top">
                    <input type="search" id='searchInput' class="form-control" placeholder="Pesquisar item...">
                    <button class="btn btn-primary" type="button" id="button-addon2"><i class='bi-search me-1'></i></button>
                </div>
                <hr>    
                <div class="col-12"><?php showMessage(); ?></div>
                <div class="col-12">
                    <?php
                        if($itemsPurchases)
                        {
                            echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4'>";
                                foreach ($itemsPurchases as $i) { 
                                    echo "<div class='col mb-3'>". getCardItem($i) ."</div>"; 
                                } 
                            echo "</div>";
                        } else {
                            echo "<h5>Você não possui itens nesta compra.</h5>";
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
    <button id="btnTop" class="btn bg-light shadow-sm text-primary px-3 fs-2"><i class="bi-arrow-bar-up"></i></button>
    <!-- MODAL ADD -->
    <div class="modal fade" id="modalAddItem" aria-hidden="true" aria-labelledby="modalAddItemLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalAddItemLabel"><i class='bi-plus-circle me-1'></i>Adicionar Item</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='formAddItem' method='POST' action='../../control/controlPurchaseItem.php?act=register-item'>
                    <div class='modal-body'>
                        <div class='mb-3'>
                            <label class='form-label'>Nome:</label>
                            <input type='text' name='name_item' class='form-control' placeholder='Digite o nome do item...'>
                            <span class='form-text text-danger d-none spanFormAddItem'>O campo nome é obrigatório!</span>
                        </div>

                        <div class='mb-3'>
                            <label class='form-label'>Unidade de Medida:</label>
                            <div class='form-check'>
                                <input class='form-check-input radio-unit' type='radio' name='unit_measurement_item' id='unitItem' value="1" checked>
                                <label class='form-check-label' for='unitItem'>Unidade (Un.)</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input radio-unit' type='radio' name='unit_measurement_item' id='kgitem' value="2">
                                <label class='form-check-label' for='kgitem'>quilograma (Kg)</label>
                            </div>
                        </div>

                        <div class='mb-3'>
                            <label id="label-quantity" class='form-label'>Quantidade de Unidades:</label>
                            <div class='input-group'>
                                <input type='text' name='quantity_item' placeholder='Digite o preço por unidade do item...' class='form-control'>
                                <span id="spanItemQuantityInfo" class='input-group-text'>Un.</span>
                            </div>
                            <span id='spanItemQuantityAlert' class='form-text text-danger d-none spanFormAddItem'>O campo quantidade de unidades é obrigatório!</span>
                        </div>

                        <label id="label-price" class='form-label'>Preço por Unidade:</label>
                        <div class='input-group'>
                            <input type='text' name='price_item' placeholder='Digite o preço do item...' class='form-control'>
                            <span class='input-group-text'>R$</span>
                        </div>
                        <span class='form-text text-danger d-none spanFormAddItem'>O campo preço é obrigatório!</span>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Adicionar Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEditItem" aria-hidden="true" aria-labelledby="modalEditItemLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalEditItemLabel"><i class='bi-pencil me-1'></i>Editar Item</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='formEditItem' method='POST' action='../../control/controlPurchaseItem.php?act=edit-item'>
                    <div class='modal-body'>
                        <input id='itemIdEdit' type='hidden' name='item_id' />
                        <div class='mb-3'>
                            <label class='form-label'>Nome:</label>
                            <input type='text' name='name_item' class='form-control inputFormEditItem' placeholder='Digite o nome do item...'>
                            <span class='form-text text-danger d-none spanFormEditItem'>O campo nome é obrigatório!</span>
                        </div>
                        <div class='mb-3'>
                            <label class='form-label'>Unidade de Medida:</label>
                            <div class='form-check'>
                                <input class='form-check-input' value='1' type='radio' name='unit_measurement_item' id='naoPerecivelEdit'>
                                <label class='form-check-label' for='naoPerecivelEdit'>Unidade (Un.)</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' value='2' type='radio' name='unit_measurement_item' id='perecivelEdit'>
                                <label class='form-check-label' for='perecivelEdit'>quilograma (Kg)</label>
                            </div>
                        </div>
                        <div class='mb-3'>
                            <label id="label-edit-quantity" class='form-label'>Quantidade de Unidades:</label>
                            <div class='input-group'>
                                <input type='text' name='quantity_item' placeholder='Digite o preço por unidade do item...' class='form-control'>
                                <span id="spanItemEditQuantityInfo" class='input-group-text'>Un.</span>
                            </div>
                            <span id='spanItemEditQuantityAlert' class='form-text text-danger d-none spanFormEditItem'>O campo quantidade de unidades é obrigatório!</span>
                        </div>
                        <label id='label-edit-price' class='form-label'>Preço Unitário:</label>
                        <div class='input-group'>
                            <input type='text' name='price_item' placeholder='Digite o preço do item...' class='form-control'>
                            <span class='input-group-text'>R$</span>
                        </div>
                        <span class='form-text text-danger d-none spanFormEditItem'>O campo preço é obrigatório!</span>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL DELETE -->
    <div class="modal fade" id="modalDeleteItem" aria-hidden="true" aria-labelledby="modalDeleteItemLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class='bi-trash me-1'></i>Remover este item?</h4>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    
                    <form id="formDeleteItem" action="../../control/controlPurchaseItem.php?act=delete-item" method="POST">
                        <input id="itemIdDelete" type="hidden" name="item_id" />
                        <button class="btn btn-danger" type="submit">Remover</button>
                    </form>
                
                </div>
            
            </div>
        </div>
    </div>
    <!--MODAL VIEW LIST-->
    <div class="modal fade" id="modalViewList" aria-hidden="true" aria-labelledby="modalViewListLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalViewListLabel"><i class='bi-card-checklist me-2'></i>Lista de Items</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class='modal-body'>
                    <div class="table-responsive">
                        <table class="table table-sm text-center table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Unidade de Medida</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if($itemsList)
                                {
                                    foreach ($itemsList as $i) { echo getTr($i, false); } 
                                } else {
                                    echo "<h5 class='mb-3'>Você não possui itens nesta lista.</h5>";
                                }
                            ?>
                            </tbody>
                        </table>                    
                    </div>
                </div>
                <div class='modal-footer'></div>
            </div>
        </div>
    </div>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../../view/assets/js/js_pages/current-purchase.js" type="module"></script>
</body>
</html>