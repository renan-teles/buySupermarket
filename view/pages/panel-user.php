<?php
    session_start();
  
    //Validate Login
    require_once '../../control/validateFunctions.php';
    validateLogin();

    //Conncetion to Database
    require_once '../../model/DAO/connectionToDatabase.php';

    //Require Services
    require_once '../services/services.php';
    
    //Get Data User
    $userData = $_SESSION['userData'];
  
    //Require Components
    include_once '../components/navs/navbar.php';
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
        <?php echo getNavbar("panel-user"); ?>
        <div class="col-12 p-5"></div>
        <main class="container pb-5">
            <div class="col-12 bg-light rounded shadow-sm p-4">
                <div class="row">
                    <div class="col-12 col-md text-center text-md-start">
                        <h2><i class='bi-person me-1'></i>Minhas Informações - Editar</h2>
                    </div>
                    <div class="col-12 col-md text-center text-start text-md-end">
                        <button id="btnModalDeleteUser" class='btn btn-danger mt-2 mt-md-0' type='button' data-bs-target='#modalDeleteUser' data-bs-toggle='modal'>
                            <i class='bi-person-x me-1'></i>Excluir Conta
                        </button>
                    </div>
                </div>
                <div class="col-12"><hr /></div>
                <div class="col-12"><?php showMessage(); ?></div>
                <form id="formEditNameAndEmail" action="../../control/controlUser.php?act=edit-name-and-email-user" method="POST">
                    <div class="col-12 mb-3">
                        <h5><i class='bi-person-gear me-1'></i>Alterar informações gerais:</h5>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label class="form-label">Nome:</label>
                            <input type="text" name="name_user" value="<?= $userData['name']; ?>" class="form-control" />
                            <span class='form-text text-danger d-none spanFormEditNameAndEmail'>O nome deve conter no mímino 4 caracteres e não conter números!</span>
                        </div>
                        <div class="col-md mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email_user" value="<?= $userData['email']; ?>" class="form-control" />
                            <span class='form-text text-danger d-none spanFormEditNameAndEmail'>Email inválido!</span>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    </div>
                </form>
                <div class="col-12"><hr /></div>
                <form id="formEditPassword" action="../../control/controlUser.php?act=edit-password-user" method="POST">
                    <div class="col-12 mb-3">
                        <h5><i class='bi-person-lock me-1'></i>Alterar senha:</h5>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label class="form-label">Nova Senha:</label>
                            <input type="password" name="new_password_user" placeholder="Digite a nova senha..." class="form-control" />
                            <span class='form-text text-danger d-none spanFormEditPassword'>A nova senha deve conter no mínimo 7 caracteres!</span>
                        </div>
                
                        <div class="col-md mb-3">
                            <label class="form-label">Senha Atual:</label>
                            <input type="password" name="password_user" placeholder="Digite a senha atual..." class="form-control" />
                            <span class='form-text text-danger d-none spanFormEditPassword'>A senha atual deve conter no mínimo 7 caracteres!</span>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button for="form2" type="submit" class="btn btn-success">Salvar Alteração</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <!-- MODAL DELETE USER -->
    <div class="modal fade" id="modalDeleteUser" aria-hidden="true" aria-labelledby="modalDeleteItemLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-2">
                    <h4><i class="bi-person-x me-1"></i>Excluir esta conta?</h4>
                    <span class='form-text'>Esta ação ira excluir os dados, compras e items associados a você nesta conta.</p>
                    <hr>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <a id='btnDeleteUser' href="../../control/controlUser.php?act=delete-user" class="btn btn-danger disabled">Excluir</a>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../../view/assets/js/js_pages/panel-user.js" type="module"></script>
</body>
</html> 