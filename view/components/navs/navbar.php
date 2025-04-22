<?php   

function getNavbar(string $active): string
{
    $component = "
    <nav class='navbar navbar-expand-md bg-light shadow-sm fixed-top'>
        <div class='container-md'>
            <a href='./my-purchases.php'> 
                <img src='../assets/img/logo_bs.png' alt='Logo BuySupermarket' style='height: 50px;'/>
            </a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav ms-auto'>
                    <li class='nav-item me-md-2 mt-2 mt-md-0'>
                        <a class='nav-link ". ($active === 'my-purchases'? "active" : "") ."' href='./my-purchases.php'><i class='bi-basket me-1'></i>Minhas Compras</a>
                    </li>
                    <li class='nav-item me-md-2 mb-2 mb-md-0'>
                        <a class='nav-link ". ($active === 'panel-user'? "active" : "") ."' href='./panel-user.php'><i class='bi-person me-1'></i>Usuário</a>
                    </li>
                    <li class='nav-item ms-md-2'>
                        <a class='btn btn-danger' href='../../control/controlUser.php?act=logout-user'><i class='bi-box-arrow-in-left me-1'></i>Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    ";
    return $component;
}