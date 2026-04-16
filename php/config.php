<div class="card table-card">
    <div class="card-header">
        <h2>Configuración</h2>
        <button class="btn btn-success btn-abrir-modal-usuario" type="button">
            <i class="fa-solid fa-plus"></i> Registrar Nuevo User
        </button>
    </div>

    <table class="tabla-usuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tbodyUsuarios">
        </tbody>
    </table>

    <div class="card-footer">
        <p>Listado de usuarios</p>
    </div>
</div>

<div id="modalUsuario" class="modal-bg" style="display: none;">
    <div class="modal-box">

        <div class="modal-top">
            <h2 id="modalTituloUsuario">Registrar Usuario</h2>
            <i class="fa-solid fa-xmark cerrar-modal"></i>
        </div>

        <form id="formUsuario">
            <input type="hidden" id="idUsuario" name="idUsuario" value="">
            <input type="hidden" id="opcionUsuario" name="opcion" value="insertarUsuario">

            <div class="modal-grid">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <select id="estado" name="estado" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <div class="modal-bottom">
                <button type="button" class="btn-lite cerrar-modal">Cancelar</button>
                <button type="submit" class="btn-main">Guardar</button>
            </div>
        </form>
    </div>
</div>