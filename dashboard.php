<?php
// Iniciamos la sesión y verificamos si el usuario está logueado
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login2.html");
    exit();
}

// Nombre del usuario logueado
$nombreUsuario = $_SESSION['nombre_usuario'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Librería de iconos -->
    <script src="https://kit.fontawesome.com/812c8ee19a.js" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous"
    >

    <!-- Fuente Poppins -->
    <link 
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" 
        rel="stylesheet"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="css/dashboard.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/faviconn (1).ico" type="image/x-icon">

    <!-- jQuery -->
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
                        <a href="#">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>

                    <li class="active">
                        <a href="#">
                            <i class="fa-solid fa-user-graduate"></i> Estudiantes
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa-solid fa-book"></i> Cursos/Grados
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa-solid fa-file-contract"></i> Matrículas
                        </a>
                    </li>

                    <li>
                        <a href="#">
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
                <div class="card table-card">
                    <div class="card-header">
                        <h2>Estudiantes Recientes</h2>
                        <button class="btn btn-primary btn-abrir-modal" type="button">
                            <i class="fa-solid fa-plus"></i> Registrar Nuevo
                        </button>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DNI</th>
                                <th>Fecha de nacimiento</th>
                                <th>Celular</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaAlumnos">
                        </tbody>
                    </table>

                    <div class="card-footer">
                        <p>Mostrando registros del sistema</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- SweetAlert primero -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tu JS después -->
    <script src="js/dashboard.js"></script>

    <!-- Bootstrap JS -->
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"
    ></script>
    
    <!-- MODAL -->
<div id="modalAlumno" class="modal-bg" style="display: none;">
    <div class="modal-box">

        <!-- HEADER -->
        <div class="modal-top">
            <h2 id="modalTitulo">Registrar Alumno</h2>
            <i class="fa-solid fa-xmark cerrar-modal"></i>
        </div>

        <!-- FORM -->
        <form id="formAlumno">
            <input type="hidden" id="id_alumno" name="id_alumno">
            <input type="hidden" id="opcion" name="opcion" value="1">

            <div class="modal-grid">
                <input type="text" id="dni" name="dni" placeholder="DNI" maxlength="8" required>
                <input type="text" id="nombres" name="nombres" placeholder="Nombres" required>

                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                <input type="date" id="fecha_nac" name="fecha_nac" required>

                <input type="number" id="edad" name="edad" placeholder="Edad" required>
                <select id="genero" name="genero" required>
                    <option value="">Género</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>

                <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>
                <select id="estado" name="estado" required>
                    <option value="">-Seleccione una opcion-</option>
                    <option value="activo">ACTIVO</option>
                    <option value="inactivo">INACTIVO</option>
                    <option value="en-proceso">EN PROCESO</option>
                </select>

                <input type="text" id="celular" name="celular" placeholder="Celular" maxlength="9" required>
                <input type="email" id="correo" name="correo" placeholder="Correo" required>

                <input type="text" id="apoderado" name="apoderado" placeholder="Apoderado" required>
                <input type="text" id="cel_apoderado" name="cel_apoderado" placeholder="Celular Apoderado" maxlength="9" required>

                <input type="text" id="username" name="username" placeholder="Usuario" required>
                <input type="password" id="password" name="password" placeholder="Contraseña">
            </div>

            <!-- FOOTER -->
            <div class="modal-bottom">
                <button type="button" class="btn-lite cerrar-modal">Cancelar</button>
                <button type="submit" class="btn-main">Guardar</button>
            </div>
        </form>

    </div>
</div>
<!-- MODAL VER ALUMNO -->
<div id="modalVerAlumno" class="modal-bg" style="display: none;">
    <div class="modal-box">
        <div class="modal-top">
            <h2>Información del Alumno</h2>
            <i class="fa-solid fa-xmark cerrar-modal-ver"></i>
        </div>

        <div class="modal-grid">
            <input type="text" id="ver_dni" placeholder="DNI" disabled>
            <input type="text" id="ver_nombres" placeholder="Nombres" disabled>

            <input type="text" id="ver_apellidos" placeholder="Apellidos" disabled>
            <input type="text" id="ver_fecha_nac" placeholder="Fecha de nacimiento" disabled>

            <input type="text" id="ver_edad" placeholder="Edad" disabled>
            <input type="text" id="ver_genero" placeholder="Género" disabled>

            <input type="text" id="ver_direccion" class="full" placeholder="Dirección" disabled>

            <input type="text" id="ver_celular" placeholder="Celular" disabled>
            <input type="text" id="ver_correo" placeholder="Correo" disabled>

            <input type="text" id="ver_apoderado" placeholder="Apoderado" disabled>
            <input type="text" id="ver_cel_apoderado" placeholder="Celular apoderado" disabled>

            <input type="text" id="ver_username" placeholder="Usuario" disabled>
            <input type="text" id="ver_estado" placeholder="Estado" disabled>
        </div>

        <div class="modal-bottom">
            <button type="button" class="btn-main cerrar-modal-ver">Cerrar</button>
        </div>
    </div>
</div>
</body>
</html>