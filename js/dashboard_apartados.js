$(document).ready(function () {

    console.log("JS apartados cargado");

    // Detectar en consola si recibe bien los datos

    if ($("#tablaPagos").length) {
        console.log("Cargando pagos...");
        listarPagos();
    }

    if ($("#tablaMatricula").length) {
        console.log("Cargando matrículas...");
        listarMatriculas();
    }


});

// ACTIVAR FUNCIONES DE LOS PAGOS A TRAVES DE BOTONES
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

// ACTIVAR FUNCIONES DE LAS MATRICULAS A TRAVES DE BOTONES
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

// 2. CERRAR MODAL REGISTRO/EDICIÓN
$('.cerrar-modal').on('click', function () {
    $('#modalMatricula').fadeOut();
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

// =========================
// PAGOS
// =========================

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
// =========================
// MATRICULA
// =========================

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
                            html += `<td><button class="btn btn-sm btn-success aprobarMatricula" id="aprobarMatricula" data-id="${matri.ID_ALUMNO}" data-nombre="${matri.ESTUDIANTE}"   >Aprobar Matrícula</button> 
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
                },
                error: function (xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });
        }
    });
}