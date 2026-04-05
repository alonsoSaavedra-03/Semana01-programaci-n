<?php
// iniciamos la sesion con session start y verificamos si el usuario esta logueado, si no lo esta lo redirigimos al login
session_start();
// el isset verifica si la variable contiene algun valor 
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
    <title>LOGIN</title>
    <!-- Libreria de Icons -->
    <script src="https://kit.fontawesome.com/812c8ee19a.js" crossorigin="anonymous"></script>
    <!-- Framework de Bootsrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Estilos de css -->
    <link rel="stylesheet" href="css/styles_index.css">
    <!-- Favicon de la aplicacion de matricula -->
    <link rel="shortcut icon" href="img/faviconn (1).ico" type="image/x-icon">
</head>
<body>
    <a href="php/logout.php" class="btn btn-danger">Cerrar sesión</a>
</body>
</html>