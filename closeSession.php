<?php
session_start();

$_SESSION = [];
session_destroy();

setcookie('email', $email, time() - 1);

header("Location: index.php?logout=ok");
?>