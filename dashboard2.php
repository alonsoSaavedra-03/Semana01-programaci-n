<?php
// Iniciamos la sesión y verificamos si el usuario está logueado
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login2.html");
    exit();
}

// Puedes mostrar el nombre si lo guardas en sesión
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fuente Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bienvenida.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/faviconn (1).ico" type="image/x-icon">

    <!-- LIBRERÍA JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="dashboard-layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="logo-box">
                    <i class="fas fa-hospital-symbol"></i>
                </div>
                <div>
                    <h2>Mi Panel</h2>
                    <p>Administración</p>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="#" class="active"><i class="fas fa-house"></i> Dashboard</a>
                <a href="#"><i class="fas fa-user-injured"></i> Estudiantes</a>
                <a href="#"><i class="fas fa-user-doctor"></i> Cursos/Grados</a>
                <a href="#"><i class="fas fa-calendar-check"></i> Matricula</a>
                <a href="#"><i class="fas fa-file-medical"></i> Pagos</a>
                <a href="#"><i class="fas fa-gear"></i> Configuración</a>
            </nav>
        </aside>

        <!-- CONTENIDO -->
        <main class="main-content">

            <!-- HEADER -->
            <header class="topbar">
                <div>
                    <h1>Dashboard</h1>
                    <p>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></p>
                </div>

                <div class="topbar-actions">
                    <button class="btn-notification">
                        <i class="fas fa-bell"></i>
                    </button>
                    <a href="php/logout.php" class="btn-logout">
                        <i class="fas fa-right-from-bracket"></i> Cerrar sesión
                    </a>
                </div>
            </header>

            <!-- TARJETAS -->
            <section class="cards-grid">
                <div class="card-box">
                    <div class="card-icon icon-one">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div>
                        <h3>128</h3>
                        <p>Pacientes registrados</p>
                    </div>
                </div>

                <div class="card-box">
                    <div class="card-icon icon-two">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3>36</h3>
                        <p>Citas de hoy</p>
                    </div>
                </div>

                <div class="card-box">
                    <div class="card-icon icon-three">
                        <i class="fas fa-user-doctor"></i>
                    </div>
                    <div>
                        <h3>14</h3>
                        <p>Médicos activos</p>
                    </div>
                </div>

                <div class="card-box">
                    <div class="card-icon icon-four">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <h3>52</h3>
                        <p>Reportes generados</p>
                    </div>
                </div>
            </section>

            <!-- SECCIÓN PRINCIPAL -->
            <section class="content-grid">

                <!-- TABLA -->
                <div class="panel-box">
                    <div class="panel-header">
                        <h2>Últimas citas</h2>
                        <a href="#">Ver todo</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table align-middle">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Juan Pérez</td>
                                    <td>Dra. Ramos</td>
                                    <td>08/04/2026</td>
                                    <td>09:00 AM</td>
                                    <td><span class="badge-status completed">Confirmada</span></td>
                                </tr>
                                <tr>
                                    <td>María López</td>
                                    <td>Dr. Torres</td>
                                    <td>08/04/2026</td>
                                    <td>10:30 AM</td>
                                    <td><span class="badge-status pending">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td>Carlos Vega</td>
                                    <td>Dra. Salazar</td>
                                    <td>08/04/2026</td>
                                    <td>11:15 AM</td>
                                    <td><span class="badge-status canceled">Cancelada</span></td>
                                </tr>
                                <tr>
                                    <td>Ana Ruiz</td>
                                    <td>Dr. Medina</td>
                                    <td>08/04/2026</td>
                                    <td>01:00 PM</td>
                                    <td><span class="badge-status completed">Confirmada</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PANEL LATERAL -->
                <div class="panel-box">
                    <div class="panel-header">
                        <h2>Resumen rápido</h2>
                    </div>

                    <div class="summary-list">
                        <div class="summary-item">
                            <span>Ingresos del mes</span>
                            <strong>S/ 8,450</strong>
                        </div>
                        <div class="summary-item">
                            <span>Pacientes nuevos</span>
                            <strong>24</strong>
                        </div>
                        <div class="summary-item">
                            <span>Citas pendientes</span>
                            <strong>11</strong>
                        </div>
                        <div class="summary-item">
                            <span>Medicamentos bajos</span>
                            <strong>7</strong>
                        </div>
                    </div>
                </div>

            </section>

        </main>
    </div>

    <div id="modalAlumno" class="modal-overlay" style="display: none;">
        <div class="modal-content">

            <div class="modal-header">
                <h2 id="modalTitulo">Registrar Nuevo Alumno</h2>
                <i class="fa-solid fa-xmark btn-cerrar-modal"></i>
            </div>

            <form id="formAlumno">
                <input type="hidden" id="id_alumno" name="id_alumno">
                <input type="hidden" id="opcion" name="opcion" value="1">

                <div class="form-grid">
                    <input type="text" id="dni" name="dni" placeholder="DNI (8 dígitos)" maxlength="8" required>

                    <input type="text" id="nombres" name="nombres" placeholder="Nombres" required>

                    <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>

                    <input type="date" id="fecha_nac" name="fecha_nac" required>

                    <input type="number" id="edad" name="edad" placeholder="Edad" required>

                    <select id="genero" name="genero" required>
                        <option value="">Seleccione Género...</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>

                    <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>

                    <input type="text" id="celular" name="celular" placeholder="Celular" maxlength="9" required>

                    <input type="email" id="correo" name="correo" placeholder="Correo Electrónico" required>

                    <input type="text" id="apoderado" name="apoderado" placeholder="Nombre Apoderado" required>

                    <input type="text" id="cel_apoderado" name="cel_apoderado" placeholder="Celular Apoderado" maxlength="9" required>

                    <input type="text" id="username" name="username" placeholder="Nombre de Usuario" required>

                    <input type="password" id="password" name="password" placeholder="Contraseña">
                </div>

                <div class="modal-footer">
                    <p>
                        PROGRAMACIÓN <br>
                        INSTRUCTOR: GIANCARLOS BARBOZA N. <br>
                        Escuela de Tecnologías de la Información
                    </p>

                    <button type="button" class="btn btn-secondary btn-cerrar-modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Guardar Datos
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- ARCHIVO JS -->
    <script src="js/dashboard.js"></script>

    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Libreria JS de bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>