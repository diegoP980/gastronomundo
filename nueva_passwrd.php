<?php
// Reemplaza esto por tu nueva contraseña
$nueva_contrasena = "tacos123";

// Generamos el hash con Bcrypt
$nuevo_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

echo "Tu nuevo hash es: <br>";
echo $nuevo_hash;
?>