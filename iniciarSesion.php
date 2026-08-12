<?php
require_once './drivers/functions.php';

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');

$errores = '';
$email = '';

if ($_POST) {
    // display($_POST);
    $email = $_POST['email'];
    $errores = validateLogin($bd, 'users', $_POST);

    if ($errores === '') {
        $user = validateUser($bd, 'users', $email);
        activarSesion($user);

        if (isset($_POST['recordarme'])) {
            setCookies($email);
        }

        header('Location: index.php?login=ok');
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="body-bg">
    <main class="d-flex justify-content-center align-items-center container-fluid min-vh-100">
        <div class="row px-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <!-- FORMULARIO -->
                <form class="row p-4 shadow-lg bg-white rounded-5" method="post" enctype="multipart/form-data">
                    <h3 class="text-center mb-4">¡Inicia sesión!</h3>
                    <div class="form-floating mb-3 col-12">
                        <input type="text" class="form-control" id="email" value="" name="email"
                            placeholder="Correo electrónico">
                        <label for="nombre" class="form-label ms-2">Correo electrónico</label>
                    </div>
                    <div class="form-floating mb-3 col-12">
                        <input type="password" class="form-control" id="password" value="" name="password"
                            placeholder="Contraseña">
                        <label for="password" class="form-label ms-2">Contraseña</label>
                    </div>
                    <div class="form-check form-switch mb-3 ms-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="recordarme" name="recordarme">
                        <label class="form-check-label" for="recordarme">Recordarme</label>
                    </div>
                    <div style="grid-template-columns: 1fr 1fr;" class="d-grid gap-0 column-gap-3">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                        <a href="index.php" class="btn btn-danger">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- ALERTA DE ERRORES -->
    <?php if ($errores !== ''): ?>
        <div class="container position-fixed top-0 start-50 translate-middle-x mt-3 col-12 col-lg-6 z-3">
            <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert">
                <h4 class="alert-heading">Errores detectados:</h4>
                <p class="mb-0">
                    <?= $errores ?>
                </p>
                <hr>
                <p class="mb-0">Verifique los campos e intente nuevamente.</p>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>