<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                <div>
                    <h2 class="mb-1">Matrículas</h2>
                    <p class="text-muted mb-0">Seleccione un estudiante para asignarlo a un curso y salón.</p>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-lg-auto">
                    <input type="text" class="form-control" placeholder="Buscar por nombre o DNI">
                    <select class="form-select">
                        <option selected>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                        <option>Pendiente</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Estudiante</th>
                            <th>DNI</th>
                            <th>Contacto</th>
                            <th>Matrícula actual</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaMatricula"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div id="modalMatricula" class="modal-bg" style="display: none;">
    <div class="modal-box">

        <div class="modal-top">
            <h2 id="modalTitulo">Matricular Alumno</h2>
            <i class="fa-solid fa-xmark cerrar-modal"></i>
        </div>

        <form id="formMatricula">
            <input type="hidden" id="id_alumno" name="id_alumno">
            <input type="hidden" id="opcion" name="opcion" value="2">

            <div class="modal-grid">
                <h4 class="nombre" id="NombreAlumno"></h4><br>

                <select id="Nivel" name="Nivel" required>
                    <option value="">Nivel</option>
                    <option value="primaria">Primaria</option>
                    <option value="secundaria">Secundaria</option>
                </select>
                <select id="Seccion" name="Seccion" required>
                    <option value="">Sección</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
                <select id="Grado" name="Grado" required>
                    <option value="">Grado</option>
                    <option value="1">1°</option>
                    <option value="2">2°</option>
                    <option value="3">3°</option>
                    <option value="4">4°</option>
                    <option value="5">5°</option>
                    <option value="6">6°</option>
                </select>

            </div>

            <div class="modal-bottom">
                <button type="button" class="btn-lite cerrar-modal">Cancelar</button>
                <button type="button" id="confirmarMatricula" class="btn-main">Aprobar</button>
            </div>
        </form>
    </div>
</div>