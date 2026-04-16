<div class="card table-card">
    <div class="card-header">
        <h2>Aulas</h2>
        <button class="btn btn-success btn-abrir-modal-aula" type="button">
            <i class="fa-solid fa-plus"></i> Registrar Nuevo
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nivel</th>
                <th>Grado</th>
                <th>Seccion</th>
                <th>Vacantes disponibles</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody id="tablaAulas"></tbody>

    </table>

    <div class="card-footer">
        <p>Listado de aulas</p>
    </div>
</div>

<div id="modalAula" class="modal-bg" style="display: none;">
    <div class="modal-box">

        <div class="modal-top">
            <h2 id="modalTitulo">Registrar Aula</h2>
            <i class="fa-solid fa-xmark cerrar-modal"></i>
        </div>

        <form id="formAula">
            <input type="hidden" id="idAula" name="idAula" value="">
            <input type="hidden" id="opcion" name="opcion" value="insertarAula">

            <div class="modal-grid">
                <input type="text" id="nombreAula" name="nombreAula" placeholder="Nivel" required>
                <input type="text" id="capacidadAula" name="capacidadAula" placeholder="Grado" required>
                <input type="text" id="seccionAula" name="seccionAula" placeholder="Seccion" required>
                <input type="text" id="vacantesAula" name="vacantesAula" placeholder="Vacantes disponibles" required>
                <input type="text" id="vacantesTotales" name="vacantesTotales" placeholder="Vacantes totales" required>
            </div>

            <div class="modal-bottom">
                <button type="button" class="btn-lite cerrar-modal">Cancelar</button>
                <button type="submit" class="btn-main btn-cerrar">Guardar</button>
            </div>
        </form>
    </div>
</div>