$(document).ready(function () {

    console.log("JS apartados cargado");

    if ($("#tablaPagos").length) {
        console.log("Cargando pagos...");
        listarPagos();
    }

    if ($("#tablaMatricula").length) {
        console.log("Cargando matrículas...");
        listarMatriculas();
    }
    if($("#tablacursos").length) {
        console.log("Cargando Cursos...");
        listadoCursos();
    }
    if($("#tablaAulas").length) {
        console.log("Cargando Aulas...");
        listadoAulas();
    }
    if($("#tbodyUsuarios").length) {
        console.log("Cargando Usuarios...");
        listarUsuarios();
    }
});
$('.btn-abrir-modal').on('click', function () {
    $('#formCurso')[0].reset();
    $('#idCurso').val('');
    $('#opcion').val('insertarCurso');
    $('#modalTitulo').text('Registrar Curso');
    $('#modalCurso').css('display', 'flex').hide().fadeIn();
});

$('.btn-abrir-modal-usuario').on('click', function () {
    $('#formUsuario')[0].reset();
    $('#idUsuario').val('');
    $('#opcionUsuario').val('insertarUsuario');
    $('#modalTituloUsuario').text('Registrar Usuario');
    $('#password').prop('required', true);

    $('#modalUsuario').css('display', 'flex').hide().fadeIn();
});

$(document).on('click', '.cerrar-modal', function () {
    $(this).closest('.modal-bg').fadeOut();
});

$('.btn-abrir-modal-aula').on('click', function () {
    $('#formAula')[0].reset();
    $('#idAula').val('');
    $('#opcion').val('insertarAula');
    $('#modalTitulo').text('Registrar Aula');
    $('#modalAula').css('display', 'flex').hide().fadeIn();
});

$('#formAula').on('submit', function (e) {
    e.preventDefault();

    guardarAula()
});



$('#formCurso').on('submit', function (e) {
    e.preventDefault();

    agregarCurso()
});
$('.btn-cerrar').on('click', function (e) {
    $('#modalCurso').fadeOut();

});
$(document).on('click', '.eliminar', function (e) {
    e.preventDefault();
    let idCurso = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarCurso(idCurso);
        }
    });
});
$(document).on('click', '.editar_usuario', function () {

    let id = $(this).data('id');
    console.log("CLICK EDITAR USUARIO:", id);

    $.ajax({
        url: "php/crud_usuario.php",
        type: "POST",
        data: { opcion: "obtenerUsuario", idUsuario: id },
        dataType: "json",

        success: function (user) {

            console.log("DATA USUARIO:", user);

            $('#idUsuario').val(user.ID);
            $('#username').val(user.USERNAME);
            $('#estado').val(user.ESTADO);

            $('#password').val('');
            $('#password').prop('required', false);

            $('#opcionUsuario').val('editarUsuario');
            $('#modalTituloUsuario').text('Editar Usuario');

            $('#modalUsuario').css('display', 'flex').hide().fadeIn();
        },

        error: function (xhr) {
            console.log("Error:", xhr.responseText);
        }
    });
});
$(document).on('click', '.eliminar_aula', function (e) {
    e.preventDefault();
    let idAula = $(this).data('id');
            eliminarAula(idAula);
});

$(document).on('click', '.editar_aula', function () {
    let idAula = $(this).data('id');
    editarAula(idAula);
});

$(document).on('click', '.editar', function() {
    let id = $(this).data('id');
    

    $('#modalTitulo').text('Editar Curso');
    $('#opcion').val('editarCurso');
    $('#idCurso').val(id);

    let fila = $(this).closest('tr');
    $('#nombreCurso').val(fila.find('.col-nombre').text());
    $('#horasCurso').val(fila.find('.col-horas').text());
    $('#descripcionCurso').val(fila.find('.col-desc').text());

    $('#modalCurso').css('display', 'flex').hide().fadeIn();
});

$(document).on('click', '#aprobarPago', function (e) {
    e.preventDefault();

    let idReserva = $(this).data('id');
    aprobarPago(idReserva);
});
$(document).on('click', '#cancelarPago', function (e) {
    e.preventDefault();

    let idReserva = $(this).data('id');
    cancelarPago(idReserva);
});

$(document).on('click', '.aprobarMatricula', function (e) {
    e.preventDefault();

    let idAlumno = $(this).data('id');
    let nombre = $(this).data('nombre');
    

    $("#id_alumno").val(idAlumno);
    $("#NombreAlumno").text(nombre);
    $("#modalMatricula").data("idAlumno", idAlumno);
    $('#formMatricula')[0].reset();
    $("#modalMatricula").css("display", "flex").hide().fadeIn();
});


$(document).on('click', '#confirmarMatricula', function () {

    let idAlumno = $("#modalMatricula").data("idAlumno");
    let nivel = $('#Nivel').val();
    let grado = $('#Grado').val();

    if (nivel === '' || grado === '') {
        alert('Seleccione nivel y grado');
        return;
    }

    aprobarMatricula(idAlumno, nivel, grado);

    $("#modalMatricula").fadeOut();
});

$(document).on('click', '#cancelarMatricula', function (e) {
    e.preventDefault();

    let idAlumno = $(this).data('id');
    cancelarMatricula(idAlumno);
});

// PAGOS

function listarPagos() {
    console.log("ENTRÓ A listarPagos");

    $.ajax({
        url: "php/crud_pagos.php",
        type: "POST",
        data: { opcion: "listar" },
        dataType: "json",

        success: function (response) {
            console.log("RESPUESTA PAGOS:", response);

            let html = "";

            response.forEach(pago => {
                const colorPago = {
                        PENDIENTE: "status-proces",
                        CANCELADO: "status-inactive",
                        PAGADO: "status-active"
                    };
                if (pago.estado === "activo" || pago.estado === "en-proceso") {
                    html += `
                    <tr>
                        <td>${pago.ID_RESERVA}</td>
                        <td>${pago.NOMBRE_ALUMNO}</td>
                        <td>${pago.AULA}</td>
                        <td>${pago.CODIGO_PAGO}</td>
                        <td>${pago.FECHA_RESERVA}</td>
                        <td><span class=" color_pago_ ${colorPago[pago.ESTADO_PAGOO]}">${pago.ESTADO_PAGOO}</span></td>
                        <td>
                            <button class="btn btn-sm btn-success" id="aprobarPago" data-id="${pago.ID_RESERVA}">Aprobar Pago</button>
                            <button class="btn btn-sm btn-danger" id="cancelarPago" data-id="${pago.ID_RESERVA}">Cancelar Pago</button>
                        </td>
                    </tr>
                `;
                } 
            });

            $("#tablaPagos").html(html);
        },

        error: function (xhr) {
            console.log("Error pagos:", xhr.responseText);
        }
    });
}

function aprobarPago(idReserva) {
    Swal.fire({
        title: 'Esta seguro de aprobar este pago?',
        text: 'si aprueba el pago, se confirmará la reserva y se marcará como pagada.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, aprobar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "php/crud_pagos.php",
                type: "POST",
                data: { opcion: "aprobar", idReserva: idReserva },
                dataType: "json",
                success: function (response) {
                    console.log("PAGO APROBADO:", response);
                    listarPagos();
                },
                error: function (xhr) {
                    console.log("Error al aprobar pago:", xhr.responseText);
                }
            });
        }
    });
}

function cancelarPago(idReserva) {
    Swal.fire({
        title: 'Esta seguro de cancelar este pago?',
        text: 'si cancela el pago, se desconfirmará la reserva y se marcará como cancelada.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "php/crud_pagos.php",
                type: "POST",
                data: { opcion: "cancelar", idReserva: idReserva },
                dataType: "json",
                success: function (response) {
                    console.log("PAGO CANCELADO:", response);
                    listarPagos();
                },
                error: function (xhr) {
                    console.log("Error al cancelar pago:", xhr.responseText);
                }
            });
        }
    });
}

// MATRICULA

function listarMatriculas() {
    console.log("ENTRÓ A listarMatriculas");

    $.ajax({
        url: "php/crud_matricula.php",
        type: "POST",
        data: { opcion: "listarmatricula" },
        dataType: "json",

        success: function (response) {
            console.log("RESPUESTA MATRICULAS:", response);

            let html = "";

            response.forEach(matri => {
                const colorMatricula = {
                        activo: "status-active",
                        inactivo: "status-inactive",
                        "en-proceso": "status-proces"
                    };
                    html += `
                    <tr>
                        <td>${matri.ID_ALUMNO}</td>
                        <td>${matri.ESTUDIANTE}</td>
                        <td>${matri.DNI_ALUMNO}</td>
                        <td>${matri.CELULAR}</td>
                        <td>${matri.MATRICULA_ACTUAL}</td>
                        <td> <span class="status-badge ${colorMatricula[matri.ESTADO]}">${matri.ESTADO}</span></td>
                        `
                        if(matri.ESTADO_MATRICULA != "ACTIVO"){
                            html += `<td><button class="btn btn-sm btn-success aprobarMatricula" id="aprobarMatricula" 
                            data-id="${matri.ID_ALUMNO}" data-nombre="${matri.ESTUDIANTE}"   >Aprobar Matrícula</button> 
                            <button class="btn btn-sm btn-danger" id="cancelarMatricula" data-id="${matri.ID_ALUMNO}">Cancelar Matrícula</button></td>`;
                        } else {
                            html += `<td><button class="btn btn-sm btn-secondary" disabled>Aprobar Matrícula</button> 
                            <button class="btn btn-sm btn-danger" id="cancelarMatricula" data-id="${matri.ID_ALUMNO}">Cancelar Matrícula</button></td>`;
                        }
                        `
                    </tr>
                `;
            });

            $("#tablaMatricula").html(html);
        },

        error: function (xhr) {
            console.log("Error matriculas:", xhr.responseText);
        }
    });
}
function aprobarMatricula(idAlumno, nivel, grado) {
    Swal.fire({
        title: '¿Está seguro de aprobar esta matrícula?',  
        text: 'Si aprueba la matrícula, se confirmará la inscripción del alumno en el curso/grado.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aprobar'
    }).then((result) => {
        if (result.isConfirmed) {
             $.ajax({
                url: "php/crud_matricula.php",
                type: "POST",
                data: {
                    opcion: "aprobarMatricula",
                    idAlumno: idAlumno,
                    nivel: nivel,
                    grado: grado
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    listarMatriculas();
                },
                error: function (xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });

        }
    });
}
function cancelarMatricula(idAlumno) {
    Swal.fire({
        title: '¿Está seguro de cancelar esta matrícula?',
        text: 'Si cancela la matrícula, se desinscribirá al alumno del curso/grado.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
             $.ajax({
                url: "php/crud_matricula.php",
                type: "POST",
                data: {
                    opcion: "cancelarMatricula",
                    idAlumno: idAlumno
                },
                dataType: "json",   
                success: function (response) {
                    console.log(response);
                    listarMatriculas();
                },
                error: function (xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });
        }
    });
}

function listadoCursos(){
    console.log("ENTRÓ A lista de Cursos");

    $.ajax({
        url: "php/crud_cursoGrados.php",
        type: "POST",
        data: { opcion: "listadoCursos" },
        dataType: "json",

        success: function (response) {
            console.log("RESPUESTA CURSOS:", response);

            let html = "";

            response.forEach(curs => {
                const colorMatricula = {
                        activo: "status-active",
                        inactivo: "status-inactive",
                        "en-proceso": "status-proces"
                    };
                    // ... dentro del response.forEach
                        html += `
                        <tr>
                            <td>${curs.ID_CURSO}</td>
                            <td class="col-nombre">${curs.NOMBRE}</td>
                            <td class="col-desc">${curs.DESCRIPCION}</td>
                            <td class="col-horas">${curs.HORAS_SEMANA}</td>
                            <td class="action-icons">
                                <i class="fa-solid fa-pen-to-square editar" data-id="${curs.ID_CURSO}"></i>
                                <i class="fa-solid fa-trash eliminar" data-id="${curs.ID_CURSO}"></i>
                            </td>
                        </tr>`;
            });

            $("#tablacursos").html(html);
        },

        error: function (xhr) {
            console.log("Error cursos:", xhr.responseText);
        }
    });
}
function agregarCurso() {

    $.ajax({
        url: "php/crud_cursoGrados.php",
        type: "POST",
        dataType: "json",
        data: $("#formCurso").serialize(),
        success: function (respuesta) {
            if (respuesta.exito) {
                $('#modalCurso').fadeOut();
                Swal.fire('¡Éxito!', respuesta.mensaje, 'success').then(() => {
                    listadoCursos();
                });
            } else {
                Swal.fire('Error', respuesta.mensaje, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ocurrió un problema al guardar los datos.', 'error');
        }
    });
}
function eliminarCurso(id) {
    $.ajax({
        url: "php/crud_cursoGrados.php",
        type: "POST",
        dataType: "json",
        data: { 
            opcion: 'eliminarCurso', 
            id: id 
        },
        success: function (respuesta) {
            if (respuesta.exito) {
                Swal.fire('Eliminado', respuesta.mensaje, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', respuesta.mensaje, 'error');
            }
        }
    });
}
function listadoAulas(){
    console.log("ENTRÓ A lista de Aulas");

    $.ajax({
        url: "php/crud_aulas.php",
        type: "POST",
        data: { opcion: "listadoAulas" },
        dataType: "json",

        success: function (response) {
            console.log("RESPUESTA AULAS:", response);

            let html = "";

            if(response.exito){
                response.datos.forEach(aula => {
                    html += `
                        <tr>
                            <td>${aula.ID_AULA}</td>
                            <td class="col-nombre">${aula.NIVEL}</td>
                            <td class="col-desc">${aula.GRADO}</td>
                            <td class="col-horas">${aula.SECCION}</td>
                            <td class="col-horas">${aula.VACANTES_DISPONIBLES}</td>
                            <td class="action-icons">
                                <i class="fa-solid fa-pen-to-square editar_aula" data-id="${aula.ID_AULA}"></i>
                                <i class="fa-solid fa-trash eliminar_aula" data-id="${aula.ID_AULA}"></i>
                            </td>
                        </tr>`;
                });
            } else {
                console.log("Error:", response.mensaje);
            }

            $("#tablaAulas").html(html);
        },

        error: function (xhr) {
            console.log("Error aulas:", xhr.responseText);
        }
    });
}
function guardarAula() {
    console.log("GUARDAR AULA");

    let id = $("#idAula").val();
    console.log("ID EN FORM:", id);

    if (id) {
        $("#opcion").val("editarAula");
    } else {
        $("#opcion").val("insertarAula");
    }

    let datos = $("#formAula").serialize();

    $.ajax({
        url: "php/crud_aulas.php",
        type: "POST",
        dataType: "json",
        data: datos,

        success: function (respuesta) {
            if (respuesta.exito) {
                $('#modalAula').fadeOut();
                Swal.fire('¡Éxito!', respuesta.mensaje, 'success')
                    .then(() => listadoAulas());
            } else {
                Swal.fire('Error', respuesta.mensaje, 'error');
            }
        }
    });
}
function eliminarAula(idAula) {
    console.log("Intentando eliminar aula con ID:", idAula);
    Swal.fire({
        title: '¿Eliminar aula?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "php/crud_aulas.php",
                type: "POST",
                dataType: "json",
                data: {
                    opcion: "eliminarAula",
                    id_aula: idAula
                },

                success: function (respuesta) {
                    if (respuesta.exito) {
                        Swal.fire('Eliminado', respuesta.mensaje, 'success');
                        listadoAulas();
                    } else {
                        Swal.fire('Error', respuesta.mensaje, 'error');
                    }
                },

                error: function (xhr) {
                    console.log("Error:", xhr.responseText);
                    Swal.fire('Error', 'No se pudo eliminar', 'error');
                }
            });

        }
    });
}
function editarAula(idAula) {
    console.log("ID A EDITAR:", idAula);
    $.ajax({
        url: "php/crud_aulas.php",
        type: "POST",
        dataType: "json",
        data: {
            opcion: "obtenerAula",
            id_aula: idAula
        },

        success: function (res) {

            if (res.exito) {
                let aula = res.datos;

                $("#idAula").val(aula.ID_AULA);
                $("#nombreAula").val(aula.NIVEL);
                $("#capacidadAula").val(aula.GRADO);
                $("#seccionAula").val(aula.SECCION);
                $("#vacantesAula").val(aula.VACANTES_DISPONIBLES);
                $("#vacantesTotales").val(aula.VACANTES_TOTALES);

                $("#modalTitulo").text("Editar Aula");
                $("#modalAula").fadeIn();

            } else {
                Swal.fire("Error", res.mensaje, "error");
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}
function listarUsuarios() {

    $.ajax({
        url: "php/crud_usuario.php",
        type: "POST",
        data: { opcion: "listarUsuarios" },
        dataType: "json",

        success: function (response) {

            let html = "";

            response.forEach(user => {
                html += `
                    <tr>
                        <td>${user.ID}</td>
                        <td>${user.USERNAME}</td>
                        <td>********</td>
                        <td>${user.ESTADO == 1 ? 'Activo' : 'Inactivo'}</td>
                        <td class="action-icons">
                            <i class="fa-solid fa-pen-to-square editar_usuario" data-id="${user.ID}"></i>
                            <i class="fa-solid fa-trash eliminar_usuario" data-id="${user.ID}"></i>
                        </td>
                    </tr>
                `;
            });

            $("#tbodyUsuarios").html(html);
        }
    });
}
$('#formUsuario').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "php/crud_usuario.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",

        success: function (res) {
            if (res.exito) {
                $('#modalUsuario').fadeOut();
                Swal.fire('Éxito', 'Usuario guardado', 'success');
                listarUsuarios();
            } else {
                Swal.fire('Error', res.mensaje, 'error');
            }
        }
    });
});
$(document).on('click', '.eliminar_usuario', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: '¿Eliminar usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "php/crud_usuario.php",
                type: "POST",
                data: { opcion: "eliminarUsuario", idUsuario: id },
                dataType: "json",

                success: function (res) {
                    if (res.exito) {
                        Swal.fire('Eliminado', 'Usuario eliminado', 'success');
                        listarUsuarios();
                    }
                }
            });
        }
    });
});