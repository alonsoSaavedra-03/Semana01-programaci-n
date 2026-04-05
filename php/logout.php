<?php
// logout.php: Este archivo se encarga de cerrar la sesión del usuario y redirigirlo al login
session_start();
session_unset();
session_destroy();
header("Location: ../login2.html");
exit();
?>