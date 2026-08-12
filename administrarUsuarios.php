<!-- Agregar las funciones -->
<?php
require_once './drivers/functions.php';

$bd = conexion('localhost', 'db_gastronomundo', 'root', '');

$errorPerfil;
$users;

if(!isset($_SESSION['nombre'])){
    header('location: index.php');
}else{
    if($_SESSION['perfil']!==9){
        echo '<h1 style="color: white; font-size: 2.5rem; background-color:red;" >No tienes permiso de Administrador</h1>';
        exit;
    }

}

$users = verUsuarios($bd, 'users');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="bg_body_admin">
    <header>
        <?php require_once './partials/navbar.php' ?>
    </header>

    <main class="container-fluid">
        <div class="container mt-5 pt-5 text-bg-dark rounded-3 shadow-lg p-3">
            <h1 class="mb-4 text-center">Administrar Usuarios</h1>
        </div>
        <div class="container mt-3 pt-3 text-bg-dark rounded-3 shadow-lg p-3">
            <table class="table table-hover table-sm table-dark table_equal_cols">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">APELLIDO</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col" class="text-center">VER PERFIL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <th scope="row"><?= $user['id'] ?></th>
                            <td><?= $user['nombre'] ?></td>
                            <td><?= $user['apellido'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td class="text-center p-0">
                                <div class="btn-group w-100" role="group" aria-label="Acciones">
                                    <a href="perfilUsuario.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>