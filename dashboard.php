<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login2.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="php/logout.php">Cerrar sesión</a>
</body>
</html>