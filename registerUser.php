<?php
require_once './drivers/functions.php';

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');

$errores = [];

$nombre = '';
$apellido = '';
$email = '';
$password = '';
$biografia = '';
$ubicacion = '';

if ($_POST) {
    // display($_POST);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $biografia = $_POST['biografia'];
    $ubicacion = $_POST['ubicacion'];
    $statusPhoto = $_FILES['photo']['error'];
    $photo;

    $errores = validarRegistroUsuario($_POST, $_FILES);
    if (count($errores) === 0) {

        if ($statusPhoto == 4) {
            $photo = null;
        } else if ($statusPhoto == 0) {
            $photo = subirImagenPerfil($_FILES);
        }

        registroUsuario($bd, 'users', $_POST, $photo);
        header('Location: index.php?register=success');
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
    <main class="d-flex align-items-center container-fluid min-vh-100">
        <div class="row px-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <!-- FORMULARIO -->
                <form class="row p-4 shadow-lg bg-white rounded-5" method="post" enctype="multipart/form-data">
                    <h3 class="text-center mb-4">¡Únete!</h3>
                    <div class="form-floating mb-3 col-6">
                        <input type="text" class="form-control" id="nombre" value="<?= $nombre ?>" name="nombre"
                            placeholder="Nombre (ej: Diego)">
                        <label for="nombre" class="form-label ms-2">Nombre (ej: Diego)</label>
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input type="text" class="form-control" id="apellido" value="<?= $apellido ?>" name="apellido"
                            placeholder="Apellido (ej: Paredes)">
                        <label for="apellido" class="form-label ms-2">Apellido (ej: Paredes)</label>
                    </div>
                    <div class="form-floating mb-3 col-12">
                        <input type="text" class="form-control" id="email" value="<?= $email ?>" name="email"
                            placeholder="Email (ej: example@email.com)">
                        <label for="nombre" class="form-label ms-2">Email (ej: example@email.com)</label>
                    </div>
                    <div class="form-floating mb-3 col-12">
                        <select class="form-select" id="ubicacion" name="ubicacion" aria-label="Ubicacion">
                            <option selected value="No precisa.">...</option>
                            <!-- LISTA DE PAISES CONSUMIENDO UNA API CON JAVASCRIPT -->
                        </select>
                        <label for="ubicacion" class="form-label ms-2">Ubicación (opcional)</label>
                    </div>
                    <div class="form-floating mb-3 col-12">
                        <textarea class="form-control" value="<?= $biografia ?>" name="biografia" placeholder="Biografía (opcional)" id="biografia"></textarea>
                        <label for="biografia" class="form-label ms-2">Biografía (opcional)</label>
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input type="password" class="form-control" id="password" value="<?= $password ?>"
                            name="password" placeholder="Contraseña">
                        <label for="password" class="form-label ms-2">Contraseña</label>
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input type="password" class="form-control" id="confirm_password" value=""
                            name="confirm_password" placeholder="Confirmar contraseña">
                        <label for="confirm_password" class="form-label ms-2">Confirmar contraseña</label>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="photo" class="form-label">Foto de perfil</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div style="grid-template-columns: 1fr 1fr;" class="d-grid gap-0 column-gap-3">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                        <a href="index.php" class="btn btn-danger">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- ALERTA DE ERRORES -->
    <?php if (count($errores) > 0): ?>
        <div class="container position-fixed top-0 start-50 translate-middle-x mt-3 col-12 col-lg-6 z-3">
            <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert">
                <h4 class="alert-heading">Errores detectados:</h4>
                <ul class="mb-0">
                    <?php foreach ($errores as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach ?>
                </ul>
                <hr>
                <p class="mb-0">Verifique los campos e intente nuevamente.</p>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="./js/restCountriesApi.js"></script>
</body>

</html>