<div class="card table-card">
    <div class="card-header">
        <h2>Grado/Curso</h2>
        <button class="btn btn-success btn-abrir-modal" type="button">
            <i class="fa-solid fa-plus"></i> Registrar Nuevo
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre curso</th>
                <th>Descripcion</th>
                <th>Horas</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody id="tablacursos"></tbody>

    </table>

    <div class="card-footer">
        <p>Listado de cursos</p>
    </div>
</div>

<div id="modalCurso" class="modal-bg" style="display: none;">
    <div class="modal-box">

        <div class="modal-top">
            <h2 id="modalTitulo">Registrar Curso</h2>
            <i class="fa-solid fa-xmark cerrar-modal"></i>
        </div>

        <form id="formCurso">
            <input type="hidden" id="idCurso" name="idCurso" value="">
            <input type="hidden" id="opcion" name="opcion" value="insertarCurso">

            <div class="modal-grid">
                <input type="text" id="nombreCurso" name="nombreCurso" placeholder="Nombre del Curso" required>
                <input type="number" id="horasCurso" name="horasCurso" placeholder="Horas" required>

                <input type="text" class="full" id="descripcionCurso" name="descripcionCurso" placeholder="Descripcion" required>
            </div>

            <div class="modal-bottom">
                <button type="button" class="btn-lite cerrar-modal">Cancelar</button>
                <button type="submit" class="btn-main btn-cerrar">Guardar</button>
            </div>
        </form>
    </div>
</div>