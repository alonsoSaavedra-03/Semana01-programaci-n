<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login2.html");
    exit();
}

$nombreUsuario = $_SESSION['nombre_usuario'] ?? 'Administrador';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script src="https://kit.fontawesome.com/812c8ee19a.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/dashboard.css">

    <link rel="stylesheet" href="css/dashboard_inicio.css">

    <link rel="shortcut icon" href="img/faviconn (1).ico" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="containers">
    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-graduation-cap"></i>
            <h2>SISTEMA DE MATRÍCULA</h2>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="dashboard.php?page=inicio">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=estudiantes">
                        <i class="fa-solid fa-user-graduate"></i> Estudiantes
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=cursoGrado">
                        <i class="fa-solid fa-book"></i> Cursos/Grados
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=matricula">
                        <i class="fa-solid fa-file-contract"></i> Matrículas
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=pagos">
                        <i class="fa-solid fa-money-bill-wave"></i> Pagos
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-gear"></i> Configuración
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://via.placeholder.com/40" alt="Avatar" width="40" height="40">
                <div class="user-info">
                    <h3><?php echo htmlspecialchars($nombreUsuario); ?></h3>
                    <a href="#">Ver perfil</a>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="header-left">
                <h2>Panel de Administración</h2>
            </div>

            <div class="header-right">
                <i class="fa-solid fa-bell"></i>

                <div class="search-bar">
                    <input type="text" placeholder="Buscar...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="user-dropdown">
                    <img src="https://via.placeholder.com/35" alt="Usuario" width="35" height="35">
                    <h3>
                        <?php echo htmlspecialchars($nombreUsuario); ?>
                        <i class="fa-solid fa-chevron-down"></i>
                    </h3>
                </div>
            </div>
        </header>

        <div class="content-body">
            <?php
                $pagina = $_GET['page'] ?? 'inicio';

                switch ($pagina) {
                    case 'estudiantes':
                        include 'php/estudiantes.php';
                        break;
                    case 'pagos':
                        include 'php/pagos.php';
                        break;
                    case 'matricula':
                        include 'php/matricula.php';
                        break;
                    case 'cursoGrado':
                        include 'php/cursoGrado.php';
                        break;
                    default:
                        include 'php/inicio.php';
                        break;
                }
            ?>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if ($pagina == 'estudiantes'): 
    echo '<script src="js/dashboard.js"></script>';
     endif; ?>

<?php if ($pagina == 'inicio'): 
    echo '<script> $(document).ready(function () {
            cargarDatosDashboard();
            });
        </script>
        <script src="js/dashboard.js"></script>';
     endif; ?>

<?php if ($pagina == 'pagos' || $pagina == 'matricula' || $pagina == 'cursoGrado'): 
    echo '<script src="js/dashboard_apartados.js"></script>';
     endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>