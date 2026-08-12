<?php
require_once './drivers/functions.php';

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');

if (!isset($_SESSION['nombre'])) {
    header('location:index.php#inicio');
}

if ($_SESSION['perfil'] !== 9) {
    echo 'No tienes permisos de Administrador';
    exit;
}

$id = $_GET['id'];

$user = verUsuario($bd, 'users', $id);

$nombre = $user['nombre'];
$apellido = $user['apellido'];
$email = $user['email'];
$errores = [];

if ($_POST) {
    $errores = validar_mensaje($_POST);
    if (count($errores) === 0) {
        enviarCorreo($_POST);
        header('Location:administrarUsuarios.php');
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Correo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="body-bg">
    <main class="d-flex align-items-center justify-content-center container-fluid min-vh-100">
        <div class="row px-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <!-- FORMULARIO -->
                <form class="row p-4 shadow-lg bg-white rounded-5" method="post" enctype="multipart/form-data">
                    <h3 class="text-center mb-4">Enviar correo</h3>
                    <div class="form-floating mb-3 col-6">
                        <input type="text" class="form-control" id="nombre" value="<?= $nombre ?>" name="nombre"
                            placeholder="Nombre (ej: Diego)">
                        <label for="nombre" class="form-label ms-2">Nombre </label>
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input type="text" class="form-control" id="apellido" value="<?= $apellido ?>" name="apellido"
                            placeholder="Apellido (ej: Paredes)">
                        <label for="apellido" class="form-label ms-2">Apellido</label>
                    </div>
                    <div class="form-floating mb-3 col-12">
                        <input type="text" class="form-control" id="email" value="<?= $email ?>" name="email"
                            placeholder="Email (ej: example@email.com)">
                        <label for="correo" class="form-label ms-2">Email </label>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Mensaje </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="mensaje" rows="3"></textarea>
                    </div>
                    <div style="grid-template-columns: 1fr 1fr;" class="d-grid gap-0 column-gap-3">
                        <button type="submit" class="btn btn-primary">Enviar correo</button>
                        <a href="perfilUsuario.php?id=<?= $id ?>" class="btn btn-outline-dark">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- ALERTA DE ERRORES -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>