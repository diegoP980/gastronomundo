<?php
session_start();

require __DIR__.'/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// require 'librerias/PHPMailer/src/Exception.php';
// require 'librerias/PHPMailer/src/PHPMailer.php';
// require 'librerias/PHPMailer/src/SMTP.php'; 

function conexion($host, $bd, $user, $password)
{
    try {
        $dns = "mysql:host=$host; dbname=$bd";

        $pdobd = new PDO($dns, $user, $password);
        return $pdobd;
    } catch (PDOException $e) {
        echo '<h2 style="color:red;">' . 'Ufff ha ocurrido un error: ' . $e->getMessage() . '</h2>';
    }
}

function display($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}

function registrarPlato($bd, $tabla, $data, $img)
{
    // display($data);
    $nombre = $data['nombre'];
    $precio = $data['precio'];
    $descuento = $data['descuento'];
    $descripcion = $data['descripcion'];
    $img;

    $sql = "INSERT INTO $tabla (name, descripcion, price, discount, image)
            VALUES(:nombre, :descripcion, :precio, :descuento, :imagen)";

    $query = $bd->prepare($sql);

    $query->bindValue(':nombre', $nombre);
    $query->bindValue(':descripcion', $descripcion);
    $query->bindValue(':precio', $precio);
    $query->bindValue(':descuento', $descuento);
    $query->bindValue(':imagen', $img);

    $query->execute();
    //  Metodo de php necesario para la ejecucion corecta de mi programa
    //  Trate de obtener el id de otro modo sin exito (como se ve mas abajo)
    //  Me apoye de la IA y revise la documentacion oficial para entender su
    //  funcionamiento el cual indica que toma por id al campo auto-incremental
    return $bd->lastInsertId();
}

function subirImagen($img)
{
    $plato = $img['imagen']['name'];
    // display($plato);
    $ext = pathinfo($plato, PATHINFO_EXTENSION);
    // display($ext);
    $origen = $img['imagen']['tmp_name'];
    // display($origen);
    $nombreImg = uniqid('img-dish-') . '.' . $ext;
    // display($nombreImg);
    //display(uniqid('IMG-'));
    //display(uniqid('CV-'));
    //display($nombreImg);

    //Ruta en el servidor
    $ruta = dirname(__DIR__) . '/img_server/';
    // display($ruta);
    // display(dirname(__DIR__).'/img_server/');
    // display($img);

    //Construccion del archivo de destino
    $destino = $ruta . $nombreImg;
    // display($destino);
    //Guardar el archivo en el destino
    move_uploaded_file($origen, $destino);
    return $nombreImg;
}

// function obtenerId($datos){
//     $id = $datos['id'];

// }
function verPlato($bd, $tabla, $id)
{
    $sql = "SELECT * FROM $tabla WHERE id = $id";

    $query = $bd->prepare($sql);

    $query->execute();

    $plato = $query->fetch(PDO::FETCH_ASSOC);

    return $plato;
}

function verPlatos($bd, $tabla)
{
    $sql = "SELECT * FROM $tabla";

    $query = $bd->prepare($sql);

    $query->execute();

    $platos = $query->fetchAll(PDO::FETCH_ASSOC);

    return $platos;
}

function validarRegistro($datos, $img)
{
    // display($datos);

    $errores = [];

    //  Estas condiciones sirven para evitar que el usuario ingrese 
    //  una cadena de puros espacios ("   ") y que el programa
    //  no la considere vacia, y si no ingresa nada le asigna
    //  una cadena vacia ('') en su lugar para luego hacer
    //  las validaciones.
    if (isset($datos['nombre'])) { // El isset verifica que el elemento exista segun la documentacion de PHP
        $nombre = trim($datos['nombre']); // trim() evita los espacios al inicio y fin del string
    } else {
        $nombre = '';
    }

    if (isset($datos['descripcion'])) {
        $descripcion = trim($datos['descripcion']);
    } else {
        $descripcion = '';
    }

    if (isset($datos['descuento'])) {
        $descuento = $datos['descuento'];
    } else {
        $descuento = '';
    }

    if (isset($img['imagen']['error'])) {
        $statusImg = $img['imagen']['error'];
    } else {
        $statusImg = 4; //  valor cuando no se sube nada
    }
    // ["error"] => int(0) === OK
    $precio = $datos['precio'];

    //  VALIDACIONES
    if ($nombre === "" || $precio === "" || $descripcion === "" || $descuento === "" || $statusImg != 0) {
        $errores['vacio'] = "No deje campos vacíos ni omita la imagen";
    }

    if ($precio < 30 || $precio > 190) {
        $errores['precio'] = "El plato debe costar entre s/30 y s/150";
    }

    return $errores;
}

function registroUsuario($db, $table, $data, $photo)
{
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $biografia = $data['biografia'];
    $ubicacion = $data['ubicacion'];
    $perfil = 1;
    $photo;

    if (!isset($data['biografia']) || empty($biografia) || $biografia == "") {
        $biografia = 'Sin biografía.';
    }

    if (!isset($data['ubicacion']) || empty($ubicacion) || $ubicacion == "") {
        $ubicacion = 'No precisa.';
    }

    $sql = "INSERT INTO $table (nombre, apellido, email, password, photo, perfil, biografia, ubicacion)
            VALUES (:nombre, :apellido, :email, :password, :photo, :perfil, :biografia, :ubicacion)";

    $query = $db->prepare($sql);

    $query->bindValue(':nombre', $nombre);
    $query->bindValue(':apellido', $apellido);
    $query->bindValue(':email', $email);
    $query->bindValue(':password', $password);
    $query->bindValue(':photo', $photo);
    $query->bindValue(':perfil', $perfil);
    $query->bindValue(':biografia', $biografia);
    $query->bindValue(':ubicacion', $ubicacion);

    $query->execute();
}

function subirImagenPerfil($photo)
{
    $photoFile = $photo['photo']['name'];
    $ext = pathinfo($photoFile, PATHINFO_EXTENSION);
    $origen = $photo['photo']['tmp_name'];
    $nombreImg = uniqid('img-perfil-') . '.' . $ext;
    //Ruta en el servidor
    $ruta = dirname(__DIR__) . '/img_server/img_server_perfil/';
    //Construccion del archivo de destino
    $destino = $ruta . $nombreImg;
    //Guardar el archivo en el destino
    move_uploaded_file($origen, $destino);
    return $nombreImg;
}

function validateLogin($db, $table, $data)
{
    $email = $data['email'];
    $password = $data['password'];
    $errores = '';


    if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores = "Correo o contraseña incorrectos. Intente nuevamente.";
    }

    if (isset($password) && $password == "") {
        $errores = "Correo o contraseña incorrectos. Intente nuevamente.";
    }

    if ($errores === '') {
        $user = validateUser($db, $table, $email);
        // display($user);
        if (!$user) {
            $errores = "Correo o contraseña incorrectos. Intente nuevamente.";
        } else {
            if (!password_verify($password, $user['password'])) {
                $errores = "Correo o contraseña incorrectos. Intente nuevamente.";
            }
        }
    }
    return $errores;
}

function validateUser($db, $tabla, $email)
{
    $sql = "SELECT * FROM $tabla
            WHERE email = :email";

    $query = $db->prepare($sql);
    $query->bindValue(':email', $email);

    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function validarRegistroUsuario($data, $photo)
{

    $errores = [];
    $extensiones = ['jpg', 'jpeg', 'png',];

    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $email = $data['email'];
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];
    $biografia = $data['biografia'];
    $ubicacion = $data['ubicacion'];
    // Extension de la foto
    $photoName = $photo['photo']['name'];
    $ext = pathinfo($photoName, PATHINFO_EXTENSION);

    // display($ext);

    if ($nombre == "" || $apellido == "" || $email == "" || $password == "" || $confirm_password == "") {
        $errores['campos'] = 'No deje campos vacíos.';
    }

    if (isset($email) && $email !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Ingrese un email válido.';
        }
    }

    if (isset($password) && $password !== "" && strlen($password) < 8) {
        $errores['password_long'] = 'Contraseña inválida (mín. 8 caracteres).';
    }

    if ($password !== $confirm_password) {
        $errores['password'] = 'Las contraseñas no coinciden.';
    }

    if (isset($ext) && $ext !== '') {
        // Existencia de la extension dentro de las extensiones permitidas (array $extensiones)
        if (!in_array($ext, $extensiones)) {
            $errores['foto'] = 'Solo se permiten imágenes en formatos JPG, JPEG y PNG';
        }
    }
    return $errores;
}

function activarSesion($user)
{
    $_SESSION['id'] = $user['id'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['apellido'] = $user['apellido'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['password'] = $user['password'];
    $_SESSION['photo'] = $user['photo'];
    $_SESSION['perfil'] = $user['perfil'];
}

function setCookies($email)
{
    setcookie('email', $email, time() + 3600);
}

function verUsuarios($bd, $tabla)
{
    $sql = "SELECT * FROM $tabla";

    $query = $bd->prepare($sql);

    $query->execute();

    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

function verUsuario($bd, $tabla, $id)
{
    $sql = "SELECT * FROM $tabla WHERE id = $id";

    $query = $bd->prepare($sql);

    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function actualizarUsuario($bd, $table, $data, $id)
{
    // var_dump($data);
    // exit;

    //Declaro variables
    $nombre = $data["nombre"];
    $apellido = $data["apellido"];
    $email = $data["email"];
    $biografia = $data["biografia"];
    !isset($data['admin']) ? $perfil = 1 : $perfil = 9;


    //Armar la consulta
    $sql = "UPDATE $table 
            SET 
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                biografia = :biografia,
                perfil = :perfil
            WHERE id = :id";

    //Preparar la consulta
    $query = $bd->prepare($sql);

    $query->bindValue(":id", $id);
    $query->bindValue(":nombre", $nombre);
    $query->bindValue(":apellido", $apellido);
    $query->bindValue(":email", $email);
    $query->bindValue(":biografia", $biografia);
    $query->bindValue(":perfil", $perfil);

    //Ejecutar la consulta
    return $query->execute();
}

function validarActualizacionUsuario($data)
{

    $errores = [];

    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $email = $data['email'];

    // display($ext);

    if ($nombre == "" || $apellido == "" || $email == "") {
        $errores['campos'] = 'No deje campos vacíos.';
    }

    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras y espacios.";
    }

    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $apellido)) {
        $errores['apellido'] = "El apellido solo puede contener letras y espacios.";
    }

    if (isset($email) && $email !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Ingrese un email válido.';
        }
    }

    return $errores;
}

function eliminarUsuario($bd, $tabla, $id){
    $sql = "DELETE FROM $tabla WHERE id = :id";

    $query = $bd->prepare($sql);

    $query->bindValue(":id", $id);

    return $query->execute();
}

function enviarCorreo($datos){
        
    $email = $datos['email'];
    $nombre = $datos['nombre'];
    $apellido = $datos['apellido'];
    $nombreCompleto = "$nombre $apellido";
    $mensaje = $datos['mensaje'];

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Permite ver errores , solo usalo cuando hagas pruebas
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'example@email.com';           //SMTP username
            $mail->Password   = 'secret';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Si se usa gmail    //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('example@email.com', 'Gastronomundo');
            $mail->addAddress($email, $nombreCompleto);     //Add a recipient
            $mail->addReplyTo('example@email.com', 'Respuesta');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = 
            "<div> 
                <h1>GASTRONOMUNDO | Administración</h1>
                <p>Hola, {$nombreCompleto}</p>
                <p>
                    Te escribimos de parte de la administración de Gastronomundo para darte la bienvenida a nuestro sitio web,
                    esperamos que te lo pases bien compartiendo tu pasión por la cocina.
                </p>
                <p>Asimismo, te dejamos un mensaje personalizado de parte de uno de nuestros administradores:</p>  
                <p>{$mensaje}</p>
                <p>Esperamos que compartas tu primera receta.</p>
                <p>Saludos.</p>
            </div>";
            $mail->AltBody = "¿Cómo te va {$nombreCompleto}?";

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

function validar_mensaje($data){
    $errores = [];
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $email = $data['email'];
    $mensaje = $data['mensaje'];

    if($nombre === ''){
            $errores['usuario'] = 'El campo nombre no debe estar vacío';
        }
        if($apellido === ''){
            $errores['apellido'] = 'El campo apellido no puede estar vacío';
        }
    if($email===''){
            $errores['email']='El campo email no puede estar vacío';
        }
    if(preg_match("/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/", $email) === 0){
            $errores['email']='El campo email no es valido';
        }
    if($mensaje===''){
        $errores['mensaje']='El campo mensaje esta vacio';
    }

    return $errores;
    }
