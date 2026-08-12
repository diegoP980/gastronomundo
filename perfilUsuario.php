<?php
require_once './drivers/functions.php';

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');

if(!isset($_SESSION['nombre'])){
    header('location: index.php');
}else{
    if($_SESSION['perfil']!==9){
        echo '<h1 style="color: white; font-size: 2.5rem; background-color:red;" >No tienes permiso de Administrador</h1>';
        exit;
    }

}




$id = $_GET['id'];
// display($id);

$user = verUsuario($bd, 'users', $id);

$nombre = $user['nombre'];
$apellido = $user['apellido'];
$email = $user['email'];
$perfil = $user['perfil'];


// display($user);

!isset($user['biografia']) || empty($user['biografia']) || $user['biografia'] == "" ? $biografia = 'Sin biografía.' : $biografia = $user['biografia'];

!isset($user['ubicacion']) || empty($user['ubicacion']) || $user['ubicacion'] == "" ? $ubicacion = 'No precisa.' : $ubicacion = $user['ubicacion'];

!isset($user['photo']) || empty($user['photo']) || $user['photo'] == "" ? $photo = 'default.png' : $photo = $user['photo'];

// display($photo);

// ======================================
// MODIFICACION DE DATOS DEL USUARIO
// ======================================

$errores = [];

if ($_POST) {
    // display($_POST);

    // ACCION: ACTUALIZAR
    if (isset($_POST['editar'])) {
        // display($_POST);
        $errores = validarActualizacionUsuario($_POST);

        if (count($errores) == 0) {
            actualizarUsuario($bd, 'users', $_POST, $id);
            header('Location: perfilUsuario.php?id=' . $id . '&update=success');
        }
    }

    // ACCION: ELIMINAR
    if (isset($_POST['eliminar'])) {
        // display($_POST);
        eliminarUsuario($bd, 'users', $id);
        header('Location: administrarUsuarios.php?delete=success');
    }

}

// ======================================
// Envio del correo
// ======================================
/*var_dump($_POST);
exit;*/
if (isset($_POST['correo'])) {
    $errores = validar_mensaje($_POST);
    if (count($errores) === 0) {
        enviarCorreo($_POST);
    }
}

$errores=[];


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Vista Administrador</title>
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos de Bootstrap (opcional, pero ayuda a la estética) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="bg_body_perfil">
    <main>
        <div class="container py-4 vh-100">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4 text-dark-emphasis">Perfil del Usuario</h1>
                </div>
            </div>

            <!-- Sección de Encabezado y Datos Principales -->
            <div>
                <div class="profile-header text-center">
                    <img src="./img_server/img_server_perfil/<?= $photo ?>" class="rounded-circle profile-img mb-3" alt="Foto de Perfil">
                    <!-- Nombre Completo -->
                    <h2 class="h3 fw-bold mb-0" id="userName"><?= "$nombre $apellido" ?></h2>
                    <!-- Correo Electrónico -->
                    <p class="lead" id="userEmail"><?= $email ?></p>
                    <!-- Estado del Usuario -->
                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill p-2 mt-2" id="userStatus">
                        <i class="bi bi-patch-check-fill me-1"></i> Activo
                    </span>
                </div>
            </div>

            <!-- Opciones de Gestión del Administrador -->
            <div class="row">
                <!-- Columna de Acciones Rápidas -->
                <div class="col-lg-4 mb-3">
                    <div class="card mb-0">
                        <div class="card-header bg-danger-subtle text-danger-emphasis">
                            <i class="bi bi-gear-fill me-2"></i> Acciones de Moderación
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted small">Herramientas para gestionar la cuenta del usuario.</p>

                            <button class="btn btn-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil-square me-1"></i> Editar Información
                            </button>

                            <button class="btn btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                                <i class="bi bi-trash me-2"></i> Eliminar Cuenta
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Columna de Datos y Recetas -->
                <div class="col-lg-8">
                    <!-- Información Detallada y Edición -->
                    <div class="card mb-0">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-person-lines-fill me-2"></i> Información de Contacto y Perfil
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-3">Nombre de Usuario:</dt>
                                <dd class="col-sm-9"><?= "$nombre $apellido" ?></dd>

                                <dt class="col-sm-3">Ubicación:</dt>
                                <dd class="col-sm-9"><?= $ubicacion ?></dd>

                                <dt class="col-sm-3">Biografía (Extracto):</dt>
                                <dd class="col-sm-9 text-truncate"><?= $biografia ?></dd>
                            </dl>
                            <button class="btn btn-outline-dark w-100" data-bs-toggle="modal"             data-bs-target="#enviar_correo">
                                <i class="bi bi-envelope-at me-1"></i> Enviar correo
                            </button>
                        </div>
                    </div>

                    <!-- Recetas Recientes del Usuario (NO IMPLEMENTADO) -->
                    <!-- <div class="card mt-4">
                        <div class="card-header bg-info-subtle text-info-emphasis">
                            <i class="bi bi-list-stars me-2"></i> Últimas 5 Recetas Publicadas
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item recipe-list-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-journal-text me-2"></i> Tarta de Queso Clásica (NY Style)</span>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">12k Vistas</span>
                            </li>
                            <li class="list-group-item recipe-list-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-journal-text me-2"></i> Ceviche Peruano de la Abuela</span>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">8.5k Vistas</span>
                            </li>
                            <li class="list-group-item recipe-list-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-journal-text me-2"></i> Lentejas Estofadas con Chorizo Vegano</span>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">4.1k Vistas</span>
                            </li>
                            <li class="list-group-item recipe-list-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-journal-text me-2"></i> Pan Casero de Masa Madre (Guía Completa)</span>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">25k Vistas</span>
                            </li>
                            <li class="list-group-item recipe-list-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-journal-text me-2"></i> Smoothie de Mango y Cúrcuma</span>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">1.3k Vistas</span>
                            </li>
                        </ul>
                        <div class="card-footer text-end">
                            <a href="#" class="btn btn-sm btn-outline-info">Ver Todas las Recetas (42)</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <a href="administrarUsuarios.php" class="btn_back position-fixed">
            <h1>
                <i class="bi bi-arrow-left-circle-fill"></i>
            </h1>
        </a>

    </main>
    <footer></footer>



    <!-- -------------------------- -->
    <!-- Modales (Ventanas Flotantes) para Acciones -->
    <!-- -------------------------- -->

    <!-- Modal para Edición de Información -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Editar Información de <?= "$nombre $apellido" ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombre ?>">
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $apellido ?>">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                        </div>
                        <div class="mb-3">
                            <label for="editBio" class="form-label">Biografía</label>
                            <textarea class="form-control" id="biografia" name="biografia" rows="3"><?= $biografia ?></textarea>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="admin" name="admin" <?= ($perfil === 9) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="admin">Otorgar Permisos de Administrador</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" name="editar">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">¿Está seguro de que desea eliminar la cuenta de <?= "$nombre $apellido" ?>?</p>
                    <p>Esta acción es irreversible.</p>
                </div>
                <div class="modal-footer">
                    <form method="post" id="deleteForm" class="d-none">
                        <input type="hidden" name="eliminar" value="1">
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger" onclick="document.getElementById('deleteForm').submit()">Eliminar Permanentemente</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal de envio de correo-->
    <div class="modal fade" id="enviar_correo" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Enviar correo a  <?= "$nombre $apellido" ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
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
                            <button type="submit" class="btn btn-primary" name="correo">Enviar correo</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje de Notificación (Reemplaza a alert()) -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="adminToast">
                <div class="toast-header bg-success text-white">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong class="me-auto">Acción de Administrador</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-light" id="toastBodyMessage">
                    Mensaje de acción.
                </div>
            </div>
        </div>
    </div>

    <!-- ALERTA DE ERRORES AL ACTUALIZAR USUARIO -->
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
    <!-- Bootstrap 5.3 JS CDN Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="./js/modalScript.js"></script>
</body>

</html>