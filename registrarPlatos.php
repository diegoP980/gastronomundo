<?php
require_once './drivers/functions.php';

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');

$errores = [];

$nombre = '';
$precio = '';
$descuento = '';
$descripcion = '';
$nameImg = '';

if ($_POST) {
    // display($_FILES['imagen']['full_path']);

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    //  isset() verifica que el campo descuento exista.
    //  Lo agregue para solucionar WARNINGS que se cargaban
    //  encima del formulario, aludiendo a que no existia
    //  ese campo.
    if (isset($_POST['descuento'])) {
        $descuento = $_POST['descuento'];
    } else {
        $descuento = '';
    }

    $descripcion = $_POST['descripcion'];

    $errores = validarRegistro($_POST, $_FILES);

    if (count($errores) === 0) {
        $img = subirImagen($_FILES);
        $id = registrarPlato($bd, 'dishes', $_POST, $img);
        header('Location: index.php?status=ok&id=' . $id);
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="body-bg">
    <main class="d-flex align-items-center container-fluid min-vh-100">
        <div class="row px-3 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <!-- FORMULARIO -->
                <form class="row p-4 shadow-lg bg-white rounded-5" method="post" enctype="multipart/form-data">
                    <h3 class="text-center mb-4">¡Comparte tu receta!</h3>
                    <div class="form-floating mb-3 col-12">
                        <input type="text" class="form-control" id="nombre" value="<?= $nombre ?>" name="nombre" placeholder="Nombre de tu receta">
                        <label for="nombre" class="form-label ms-2">Nombre de tu receta</label>
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input type="number" class="form-control" id="precio" value="<?= $precio ?>" name="precio" placeholder="Precio">
                        <label for="precio" class="form-label ms-2">Precio ( s/ )</label>
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <select class="form-select" id="descuento" name="descuento">
                            <!-- Seleccion dinamica si hay errores con condiciones ternarias (if/else resumido)-->
                            <option value="" disabled <?= ($descuento == '') ? 'selected' : '' ?>></option>
                            <option value="10" <?= ($descuento == '10') ? 'selected' : '' ?>>10</option>
                            <option value="15" <?= ($descuento == '15') ? 'selected' : '' ?>>15</option>
                            <option value="20" <?= ($descuento == '20') ? 'selected' : '' ?>>20</option>
                        </select>
                        <label for="descuento" class="ms-2">Descuento</label>
                    </div>
                    <div class="form-floating mb-3 col-12">
                        <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion"><?= $descripcion ?></textarea>
                        <label for="descripcion" class="form-label ms-2">Descripcion</label>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="imagen" class="form-label">Referencia visual:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>
                    <div style="grid-template-columns: 1fr 1fr;" class="d-grid gap-0 column-gap-3">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                        <a href="index.php" class="btn btn-danger">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- ALERTA DE ERRORES -->
    <?php if (count($errores) > 0) : ?>
        <div class="container position-fixed top-0 start-50 translate-middle-x mt-3 col-12 col-lg-6 z-3">
            <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert">
                <h4 class="alert-heading">Errores detectados:</h4>
                <ul class="mb-0">
                    <?php foreach ($errores as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach ?>
                </ul>
                <hr>
                <p class="mb-0">Verifique los campos e intente nuevamente.</p>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>