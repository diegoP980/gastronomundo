<?php

require_once './drivers/functions.php';

$bd = conexion('localhost', 'restaurant', 'root', '');

$perfil = 1;

if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];

    $user = validateUser($bd, 'users', $email);
    activarSesion($user);
}

isset($_SESSION) && count($_SESSION) > 0 ? $perfil = $_SESSION['perfil'] : $perfil = 1;
?>

<nav class="navbar navbar-expand-sm fixed-top bg-body-tertiary shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php#inicio">
            <img src="./img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-2">
            Gastronomundo
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php#inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#nosotros">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#recetas">Recetas</a>
                </li>
                <?php if ($perfil == 9): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="administrarUsuarios.php">Administrador</a>
                    </li>
                <?php endif ?>
            </ul>
            <?php if (count($_SESSION) == 0): ?>
                <div class="d-flex">
                    <a href="registerUser.php" class="btn btn-info px-5 me-3">Únete</a>
                </div>
                <div class="d-flex">
                    <a href="iniciarSesion.php" class="btn btn-info px-4">Iniciar Sesión</a>
                </div>
            <?php else: ?>
                <div class="nav-item dropdown">
                    <a class="nav-link d-flex dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <p class="m-0"><?= $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] ?></p>
                        </div>
                        <div class="d-flex ms-3" style="height: 40px;">
                            <img class="rounded img-fluid" src="./img_server/img_server_perfil/<?= $_SESSION['photo'] ?>"
                                alt="<?= $_SESSION['nombre'] ?>">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Recetas</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="closeSession.php">Cerrar sesión</a></li>
                    </ul>
                </div>
            <?php endif ?>
        </div>
    </div>
</nav>