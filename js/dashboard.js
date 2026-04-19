let chartGenero = null;
let chartNiveles = null;
$(document).ready(function () {
    
    // 1. ABRIR MODAL PARA NUEVO REGISTRO
    $('.btn-abrir-modal').on('click', function () {
        $('#formAlumno')[0].reset();
        $('#id_alumno').val('');
        $('#opcion').val('1');
        $('#modalTitulo').text('Registrar Nuevo Alumno');
        $('#password').attr('required', true);
        $('#modalAlumno').css('display', 'flex').hide().fadeIn();
    });
    
    // 2. CERRAR MODAL REGISTRO/EDICIÓN
    $('.cerrar-modal').on('click', function () {
        $('#modalAlumno').fadeOut();
    });

    $('#modalAlumno').on('click', function (e) {
        if ($(e.target).is('#modalAlumno')) {
            $(this).fadeOut();
        }
    });

    // 3. CERRAR MODAL VER
    $(document).on('click', '.cerrar-modal-ver', function () {
        $('#modalVerAlumno').fadeOut();
    });

    $('#modalVerAlumno').on('click', function (e) {
        if ($(e.target).is('#modalVerAlumno')) {
            $(this).fadeOut();
        }
    });

    // 4. ENVIAR FORMULARIO
    $('#formAlumno').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "php/crud_alumnos.php",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),
            success: function (respuesta) {
                if (respuesta.exito) {
                    $('#modalAlumno').fadeOut();
                    Swal.fire('¡Éxito!', respuesta.mensaje, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', respuesta.mensaje, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Ocurrió un problema al guardar los datos.', 'error');
            }
        });
    });

    // 5. ELIMINAR
    $(document).on('click', '.fa-trash', function () {
        let fila = $(this).closest('tr');
        let idAlumno = fila.find('td:eq(0)').text().trim();

        Swal.fire({
            title: '¿Eliminar Alumno?',
            text: 'Se borrará permanentemente de la Base de Datos.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "php/crud_alumnos.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        opcion: 3,
                        id_alumno: idAlumno
                    },
                    success: function (respuesta) {
                        if (respuesta.exito) {
                            fila.fadeOut(400, function () {
                                $(this).remove();
                            });
                            Swal.fire('Eliminado', respuesta.mensaje, 'success');
                        } else {
                            Swal.fire('Error', respuesta.mensaje, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo eliminar el alumno.', 'error');
                    }
                });
            }
        });
    });

    // 6. EDITAR
    $(document).on('click', '.fa-pen-to-square', function () {
        let fila = $(this).closest('tr');
        let idAlumno = fila.find('td:eq(0)').text().trim();

        $.ajax({
            url: "php/crud_alumnos.php",
            type: "POST",
            dataType: "json",
            data: {
                opcion: 5,
                id_alumno: idAlumno
            },
            success: function (alumno) {
                $('#formAlumno')[0].reset();

                $('#id_alumno').val(alumno.ID_ALUMNO);
                $('#opcion').val('2');
                $('#modalTitulo').text('Editar Alumno');
                $('#password').val('');
                $('#password').removeAttr('required');

                $('#dni').val(alumno.DNI_ALUMNO);
                $('#nombres').val(alumno.NOMBRES);
                $('#apellidos').val(alumno.APELLIDOS);
                $('#fecha_nac').val(alumno.FECHA_NACIMIENTO);
                $('#edad').val(alumno.EDAD);
                $('#genero').val(alumno.GENERO);
                $('#direccion').val(alumno.DIRECCION);
                $('#celular').val(alumno.CELULAR);
                $('#correo').val(alumno.CORREO);
                $('#apoderado').val(alumno.NOMBRE_APODERADO);
                $('#cel_apoderado').val(alumno.CELULAR_APODERADO);
                $('#username').val(alumno.USERNAME);
                $('#estado').val(alumno.estado);

                $('#modalAlumno').css('display', 'flex').hide().fadeIn();
            },
            error: function () {
                Swal.fire('Error', 'No se pudieron cargar los datos del alumno.', 'error');
            }
        });
    });

    // 7. VER
    $(document).on('click', '.btn-ver', function () {
        let fila = $(this).closest('tr');
        let idAlumno = fila.find('td:eq(0)').text().trim();

        $.ajax({
            url: "php/crud_alumnos.php",
            type: "POST",
            dataType: "json",
            data: {
                opcion: 5,
                id_alumno: idAlumno
            },
            success: function (alumno) {
                $('#ver_dni').val(alumno.DNI_ALUMNO);
                $('#ver_nombres').val(alumno.NOMBRES);
                $('#ver_apellidos').val(alumno.APELLIDOS);
                $('#ver_fecha_nac').val(alumno.FECHA_NACIMIENTO);
                $('#ver_edad').val(alumno.EDAD);
                $('#ver_genero').val(alumno.GENERO);
                $('#ver_direccion').val(alumno.DIRECCION);
                $('#ver_celular').val(alumno.CELULAR);
                $('#ver_correo').val(alumno.CORREO);
                $('#ver_apoderado').val(alumno.NOMBRE_APODERADO);
                $('#ver_cel_apoderado').val(alumno.CELULAR_APODERADO);
                $('#ver_username').val(alumno.USERNAME);
                $('#ver_estado').val(alumno.estado);

                $('#modalVerAlumno').css('display', 'flex').hide().fadeIn();
            },
            error: function () {
                Swal.fire('Error', 'No se pudieron cargar los datos del alumno.', 'error');
            }
        });
    });

    // 8. CARGAR TABLA
    function cargarAlumnos() {
        $.ajax({
            url: "php/crud_alumnos.php",
            type: "POST",
            dataType: "json",
            data: { opcion: 4 },
            success: function (data) {
                let tbody = $('#tablaAlumnos');
                tbody.empty();

                $.each(data, function (index, alumno) {
                    const statusClass = {
                        activo: "status-active",
                        inactivo: "status-inactive",
                        "en-proceso": "status-proces"
                    };

                    let fila = `
                        <tr>
                            <td>${alumno.ID_ALUMNO}</td>
                            <td>${alumno.NOMBRES}</td>
                            <td>${alumno.APELLIDOS}</td>
                            <td>${alumno.DNI_ALUMNO}</td>
                            <td>${alumno.FECHA_NACIMIENTO}</td>
                            <td>${alumno.CELULAR}</td>
                            <td>${alumno.CORREO}</td>
                            <td>
                                <span class="status-badge ${statusClass[alumno.estado] || ""}">
                                    ${alumno.estado}
                                </span>
                            </td>
                            <td class="action-icons">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <i class="fa-solid fa-eye btn-ver"></i>
                                <i class="fa-solid fa-trash"></i>
                            </td>
                        </tr>
                    `;

                    tbody.append(fila);
                });
            },
            error: function () {
                console.log("Error al cargar los datos de la tabla.");
            }
        });
    }
    cargarAlumnos();
});

function dibujarGraficoGenero(etiquetas, datos) {
    let ctx = document
        .getElementById('graficoGenero')
        .getContext('2d');

    if (chartGenero) {
        chartGenero.destroy();
    }

    chartGenero = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: etiquetas,
            datasets: [
                {
                    data: datos,
                    backgroundColor: [
                        '#3498DB',
                        '#E74C3C',
                        '#F1C40F'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function dibujarGraficoNiveles(etiquetas, totales, disponibles) {
    let ctx = document
        .getElementById('graficoNiveles')
        .getContext('2d');

    if (chartNiveles) {
        chartNiveles.destroy();
    }

    chartNiveles = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: etiquetas,
            datasets: [
                {
                    label: 'Vacantes Totales',
                    data: totales,
                    backgroundColor: '#95A5A6',
                    borderRadius: 4
                },
                {
                    label: 'Vacantes Disponibles',
                    data: disponibles,
                    backgroundColor: '#2ECC71',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
function cargarDatosDashboard() {
    $.ajax({
        url: "php/dashboard_datos.php",
        type: "GET",
        dataType: "json",
        success: function (respuesta) {

            $('#kpiTotalAlumnos').text(respuesta.datos.kpis.totalAlumnos);
            $('#kpiTotalAulas').text(respuesta.datos.kpis.totalAulas);
            $('#kpiVacantesDisp').text(respuesta.datos.kpis.vacantesDisp);

            let generos = respuesta.datos.graficos.genero;

            let etiquetasGenero = generos.map(g => g.GENERO);
            let datosGenero = generos.map(g => g.cantidad);

            dibujarGraficoGenero(etiquetasGenero, datosGenero);

            let niveles = respuesta.datos.graficos.niveles;

            let etiquetasNiveles = niveles.map(n => n.NIVEL);
            let totales = niveles.map(n => n.totales);
            let disponibles = niveles.map(n => n.disponibles);

            dibujarGraficoNiveles(etiquetasNiveles, totales, disponibles);
        },
        error: function () {
            console.log("Error cargando dashboard");
        }
    });
}