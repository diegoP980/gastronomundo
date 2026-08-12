<?php
require_once './drivers/functions.php';

// display($_SESSION);

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');
//var_dump($_SESSION);
//exit;
if ($_GET) {
    if (isset($_GET['register']) && $_GET['register']) {
        $register = $_GET['register'];
    }

    if (isset($_GET['login']) && $_GET['login']) {
        $login = $_GET['login'];
    }

    if (isset($_GET['id']) && $_GET['id']) {
        $id = $_GET['id'];
        $plato = verPlato($bd, 'dishes', $id);
    }
}

// CAMBIO DE TEMA DINAMICO (NO IMPLEMENTADO)
// $theme = '';

// if (isset($_SESSION)) {
//     $_SESSION['perfil'] == 9 ? $theme = 'dark' : $theme = 'light';
// } else {
//     $theme = 'light';
// }

$platos = verPlatos($bd, 'dishes');

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gastronomundo®</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body id="inicio">
    <header>
        <?php require_once './partials/navbar.php' ?>
    </header>

    <main class="overflow-hidden">
        <div class="container-fluid text-light text-center d-flex flex-column justify-content-end banner">
            <div class="mb-5">
                <h1 class="banner-title">Los platos mas creativos a nivel mundial</h1>
                <p class="banner-subtitle">Los encuentras aqui</p>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center" style="height: 400px;">
                <div class="col-6 col-md-8 col-lg-8">
                    <h2>La carta mas variada</h2>
                    <p>
                        Explora los platos más creativos del mundo. Comparte tus recetas únicas, descubre sabores
                        exóticos y celebra la diversidad culinaria global en una comunidad apasionada por la innovación
                        gastronómica.
                    </p>
                </div>
                <div class="col-6 col-md-4 col-lg-4">
                    <img class="w-100 img-fluid" src="./img/img01.jpg" alt="">
                </div>
            </div>
        </div>
        <div id="nosotros"
            class="container-fluid text-light text-center d-flex flex-column justify-content-center container-01">
            <div>
                <h1 class="banner-title">El limite es tu imaginación</h1>
                <p class="banner-subtitle">Admitimos cualquier tipo de plato, sin importar los ingredientes o tipo de
                    preparación</p>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center" style="height: 400px;">
                <div class="col-6 col-md-4 col-lg-4">
                    <img class="w-100 img-fluid" src="./img/img03.jpg" alt="">
                </div>
                <div class="col-6 col-md-8 col-lg-8">
                    <h2>Sin fronteras</h2>
                    <p>
                        Disfrutar de la buena comida significa valorar cada sabor sin importar su origen; aporta
                        tradiciones y creatividad que enriquecen el paladar y cuentan historias de culturas, hogares y
                        experiencias.
                    </p>
                </div>
            </div>
        </div>
        <div class="container-fluid text-light text-center d-flex flex-column justify-content-center container-02">
            <div class="container">
                <h1 class="banner-title">¡Comparte tu pasión por la cocina!</h1>
                <div class="row justify-content-center banner-subtitle">
                    <div class="col-12 col-md-8 col-lg-6">
                        <p>
                            En este espacio celebramos la creatividad culinaria en todas sus formas. No importa si tu
                            receta
                            nació de la inspiración del momento, de una tradición familiar o de una simple mezcla
                            improvisada,
                            todas las ideas son bienvenidas.
                        </p>
                        <p>
                            ¡Aquí, lo importante no es ser un chef de cinco estrellas, sino disfrutar el arte de
                            cocinar!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-4">
            <h1 class="text-center mb-4" id="recetas">Recetas</h1>
            <!-- Si no hay registros me muestra una alerta -->
            <?php if (empty($platos)): ?>
                <div class="alert alert-warning text-center" role="alert">
                    No hay registros existentes.
                </div>
            <?php else: ?>
                <!-- Si hay registros muestra las tarjetas -->
                <div class="row g-3 justify-content-center">
                    <?php foreach ($platos as $plato): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div style="height: 200px;" class="overflow-hidden">
                                    <img src="./img_server/<?= $plato['image'] ?>" class="card-img-top object-fit-cover"
                                        alt="<?= $plato['name'] ?>" class="img-fluid">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $plato['name'] ?></h5>
                                    <div class="overflow-auto border rounded p-2" style="height: 68px">
                                        <p class="card-text"><?= $plato['descripcion'] ?></p>
                                    </div>
                                    <p class="card-text mt-2">Precio: s/. <?= $plato['price'] ?> (<?= $plato['discount'] ?>%
                                        off)</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <a href="registrarPlatos.php" class="btn btn-outline-info position-fixed bottom-0 end-0 m-4 shadow-lg">Agregar
            plato</a>
    </main>
    <footer class="text-bg-dark text-center py-3 mt-5">
        <p class="mb-0">Gastronomundo® | Todos los derechos reservados.</p>
    </footer>
    <!-- MODAL SI EL REGISTRO ES EXITOSO -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'ok'): ?>
        <div class="modal fade" id="okRegistro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">¡Plato registrado!</h1>
                    </div>
                    <div class="modal-body row mx-3 align-items-center">
                        <div class="col-6">
                            <h4 class="text-center"><?= $plato['name'] ?></h4>
                            <div>
                                <h6>Descripción:</h6>
                                <p><?= $plato['descripcion'] ?></p>
                                <p>Precio: s/ <?= $plato['price'] ?></p>
                                <p>Descuento: <?= $plato['discount'] ?> %</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <img src="./img_server/<?= $plato['image'] ?>" alt="img-dish" class="img-fluid">
                        </div>
                        <h4 class="text-center mt-3">¿Desea agregar más platos?</h4>
                    </div>
                    <div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">No</button>
                            <a href="registrarPlatos.php" class="btn btn-outline-info">Sí, registrar una nueva receta</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endif ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- El script del evento del modal se tiene que cargar luego del script de bootstrap -->
    <script src="./js/modalScript.js"></script>

</body>

</html>