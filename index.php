<?php 
    session_start();
    require_once './control/validateFunctions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Supermarket</title>
    <link rel="icon" href="./view/assets/img/logo_bs.png" type="image/png">
    <link rel="stylesheet" href="view/assets/css/style.css">
    <link rel="stylesheet" href="view/assets/css/css_bootstrap/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid bg-img" >
        <main class="col-12 d-flex justify-content-center align-items-center" style="height: 100dvh;">
            <form id='form' action='./control/controlUser.php?act=login-user' method='POST' class='col-12 col-sm-8 col-md-6 col-lg-5 bg-light p-4 shadow rounded'>
                <div class='mb-3 text-center'>
                    <img src='./view/assets/img/logo_bs.png' alt='Logo Buy Supermarket' style='width: 90px;'>
                    <h6>Buy Supermarket</h6>
                    <h5>Entre Com Sua Conta</h5>
                </div>
                <hr>
                <div class='mb-3'>
                    <?php echo showMessage(); ?>
                </div>
                <div class='mb-3'>
                    <label class='form-label'>Email:</label>
                    <input type='email' class='form-control' name='email_user' placeholder='Digite seu email...' />
                    <span class='form-text text-danger d-none'>Email inválido!</span>
                </div>
                <div class='mb-3'>
                    <label class='form-label'>Senha:</label>
                    <input type='password' class='form-control' name='password_user' placeholder='Digite sua senha...' />
                    <span class='form-text text-danger d-none'>A senha deve conter no mínimo 7 caracteres!</span>
                </div>
                <hr>
                <div>
                    <button type='submit' class='btn btn-success col-12 mb-1'>Entrar</button>
                    <a href='./view/pages/register-user.php' class='btn btn col-12'>Crie Sua Conta</a>
                </div>
            </form>
        </main>
    </div>
    <script src="view/assets/js/js_bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./view/assets/js/js_pages/login-user.js" type="module"></script>
</body>
</html>