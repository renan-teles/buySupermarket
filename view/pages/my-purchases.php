<?php
    session_start();

    //Validate Login
    require_once '../../control/validateFunctions.php';
    validateLogin();
    
    //Conncetion to Database
    require_once '../../model/DAO/connectionToDatabase.php';

    //Require Services
    require_once '../services/services.php';

    unset($_SESSION['currentPurchaseData']);

    //Get Data User
    $userData = $_SESSION['userData'];

    //Get User Purchases
    $purchasesUser = getUserPurchases($userData['id'], $connectionDB);

    //Verify User Purchases
    if($purchasesUser === false)
    {
        $_SESSION['msg-errors'] = ['Erro ao buscar compras de usuário!'];
    }
    
    //Requires Components
    include_once '../components/navs/navbar.php';
    include_once '../components/cards/cardPurchase.php';
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
        <?php echo getNavbar("my-purchases"); ?>
        <div class="col-12 p-5"></div>
        <main class="container-md pb-5">
            <div class="col-12 bg-light rounded shadow-sm p-4">
                <div class="row mb-3">
                    <div class="col-12 col-md text-center text-md-start">
                       <h2><i class="bi-cart4 me-2"></i>Minhas Compras</h2>
                    </div>
                    <div class="col-12 col-md text-center text-md-end mt-2 mt-md-0">
                        <button class="btn btn-primary" type="button" data-bs-target="#modalAddPuchase" data-bs-toggle="modal">
                           <i class="bi-cart-plus me-1"></i>Criar Compra
                        </button>
                    </div>
                </div>
                <div id="divSearch" class="input-group sticky-top">
                    <input type="search" id='searchInput' class="form-control" placeholder="Pesquisar Compra...">
                    <button class="btn btn-primary" type="button" id="button-addon2"><i class='bi-search me-1'></i></button>
                </div>
                <div class="col-12"><hr /></div>
                <div class="col-12">
                    <div class="col-12"><?php showMessage(); ?></div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4">
                        <?php 
                            if($purchasesUser)
                            {
                                foreach ($purchasesUser as $p) { echo "<div class='col mb-3'>". getCardPurchase($p) ."</div>"; } 
                            } else {
                                echo "<h5>Você não possui compras.</h5>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <button id="btnTop" class="btn bg-light shadow-sm text-primary px-3 fs-2"><i class="bi-arrow-bar-up"></i></button>
    <!-- MODAL ADD -->
    <div class="modal fade" id="modalAddPuchase" aria-hidden="true" aria-labelledby="modalAddPuchaseLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalAddPuchaseLabel"> <i class="bi-cart-plus me-1"></i>Criar Compra</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='formAddPurchase' method='POST' action='../../control/controlPurchase.php?act=register-purchase'>
                    <div class='modal-body'>
                        <div class='mb-3'>
                            <label class='form-label'>Nome:</label>
                            <input type='text' name='name_purchase' class='form-control' placeholder='Digite o nome da compra...'>
                            <span class='form-text text-danger d-none spanFormAddPurchase'>O campo nome é obrigatório!</span>
                        </div>
                        <label class='form-label'>Gasto Máximo:</label>
                        <div class='input-group'>
                            <input type='text' name='max_spend_purchase' placeholder='Digite o gasto máximo da compra...' class='form-control'>
                            <span class='input-group-text'>R$</span>
                        </div>
                        <span class='form-text text-danger d-none spanFormAddPurchase'>O campo gasto máximo é obrigatório!</span>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Criar Compra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEditPuchase" aria-hidden="true" aria-labelledby="modalEditPuchaseLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="modalEditPuchaseLabel"><i class="bi-pencil me-2"></i>Editar Compra</h1>
                    <button type="button" id="btnClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='formEditPurchase' method='POST' action='../../control/controlPurchase.php?act=edit-purchase'>
                    <div class='modal-body'>
                        <input id='purchaseIdEdit' type='hidden' name='purchase_id' />
                        <div class='mb-3'>
                            <label class='form-label'>Nome:</label>
                            <input type='text' name='name_purchase' class='form-control' placeholder='Digite o nome da compra...'>
                            <span class='form-text text-danger d-none spanFormEditPurchase'>O campo nome é obrigatório!</span>
                        </div>
                        <label class='form-label'>Gasto Máximo:</label>
                        <div class='input-group'>
                            <input type='text' name='max_spend_purchase' placeholder='Digite o gasto máximo da compra...' class='form-control'>
                            <span class='input-group-text'>R$</span>
                        </div>
                        <span class='form-text text-danger d-none spanFormEditPurchase'>O campo gasto máximo é obrigatório!</span>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Salvar Alterações</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
    <!-- MODAL DELETE -->
    <div class="modal fade" id="modalDeletePuchase" aria-hidden="true" aria-labelledby="modalDeletePuchaseLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-trash me-1"></i>Excluir esta compra?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <form id="formDeletePurchase" action="../../control/controlPurchase.php?act=delete-purchase" method="POST">
                        <input id="purchaseIdDelete" type="hidden" name="purchase_id" />
                        <button class="btn btn-danger" type="submit">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../../view/assets/js/js_pages/my-purchases.js" type="module"></script>
</body>
</html>