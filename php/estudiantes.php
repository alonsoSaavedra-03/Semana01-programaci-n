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
        <tbody id="tablaAlumnos"></tbody>
    </table>

    <div class="card-footer">
        <p>Mostrando registros del sistema</p>
    </div>
</div>

<!-- MODAL -->
<div id="modalAlumno" class="modal-bg" style="display: none;">
    <div class="modal-box">

        <div class="modal-top">
            <h2 id="modalTitulo">Registrar Alumno</h2>
            <i class="fa-solid fa-xmark cerrar-modal"></i>
        </div>

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

            <div class="modal-bottom">
                <button type="button" class="btn-lite cerrar-modal">Cancelar</button>
                <button type="submit" class="btn-main">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL VER -->
<div id="modalVerAlumno" class="modal-bg" style="display: none;">
    <div class="modal-box">
        <div class="modal-top">
            <h2>Información del Alumno</h2>
            <i class="fa-solid fa-xmark cerrar-modal-ver"></i>
        </div>

        <div class="modal-grid">
            <input type="text" id="ver_dni" disabled>
            <input type="text" id="ver_nombres" disabled>
            <input type="text" id="ver_apellidos" disabled>
            <input type="text" id="ver_fecha_nac" disabled>
            <input type="text" id="ver_edad" disabled>
            <input type="text" id="ver_genero" disabled>
            <input type="text" id="ver_direccion" class="full" disabled>
            <input type="text" id="ver_celular" disabled>
            <input type="text" id="ver_correo" disabled>
            <input type="text" id="ver_apoderado" disabled>
            <input type="text" id="ver_cel_apoderado" disabled>
            <input type="text" id="ver_username" disabled>
            <input type="text" id="ver_estado" disabled>
        </div>

        <div class="modal-bottom">
            <button type="button" class="btn-main cerrar-modal-ver">Cerrar</button>
        </div>
    </div>
</div>