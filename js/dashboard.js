$(document).ready(function () {

    // 1. ABRIR MODAL PARA NUEVO REGISTRO
    $('.btn-abrir-modal').on('click', function () {
        $('#formAlumno')[0].reset();
        $('#opcion').val('1');
        $('#modalTitulo').text('Registrar Nuevo Alumno');
        $('#password').attr('required', true);
        $('#modalAlumno').css('display', 'flex').hide().fadeIn();
    });

    // 2. CERRAR MODAL  
    $('.cerrar-modal').on('click', function () {
        $('#modalAlumno').fadeOut();
    });
    $('#modalAlumno').on('click', function (e) {
        if ($(e.target).is('#modalAlumno')) {
            $(this).fadeOut();
        }
    });
    // ABRIR MODAL VER
    $(document).on('click', '.btn-ver', function () {

        let fila = $(this).closest("tr");
    
        $("#ver_dni").val(fila.find(".dni").text());
        $("#ver_nombres").val(fila.find(".nombres").text());
        $("#ver_apellidos").val(fila.find(".apellidos").text());
        $("#ver_fecha_nac").val(fila.find(".fecha_nac").text());
        $("#ver_edad").val(fila.find(".edad").text());
        $("#ver_genero").val(fila.find(".genero").text());
        $("#ver_direccion").val(fila.find(".direccion").text());
        $("#ver_celular").val(fila.find(".celular").text());
        $("#ver_correo").val(fila.find(".correo").text());
        $("#ver_apoderado").val(fila.find(".apoderado").text());
        $("#ver_cel_apoderado").val(fila.find(".cel_apoderado").text());
        $("#ver_username").val(fila.find(".username").text());
    
        $("#modalVerAlumno").css("display", "flex").hide().fadeIn();
    });
    
    $(document).on('click', '.cerrar-modal-ver', function () {
        $("#modalVerAlumno").fadeOut();
    });
    
    $("#modalVerAlumno").on("click", function(e){
        if ($(e.target).is("#modalVerAlumno")) {
            $(this).fadeOut();
        }
    });

    
    // 3. ENVIAR FORMULARIO (CREAR O EDITAR)
    $('#formAlumno').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "php/crud_alumnos.php",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(), // Empaqueta todos los 14 campos automáticamente

            success: function (respuesta) {
                if (respuesta.exito) {
                    $('#modalAlumno').fadeOut();

                    Swal.fire('¡Éxito!', respuesta.mensaje, 'success').then(() => {
                        location.reload(); // Recargar para ver los cambios en la tabla
                    });
                } else {
                    Swal.fire('Error', respuesta.mensaje, 'error');
                }
            }
        });
    });

    // 4. ELIMINAR REGISTRO
    $(document).on('click', '.fa-trash', function () {
        let fila = $(this).closest('tr');
        let idAlumno = fila.find('td:eq(0)').text();

        Swal.fire({
            title: '¿Eliminar Alumno?',
            text: "Se borrará permanentemente de la Base de Datos.",
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
                    }, // Enviamos opción 3 (Eliminar) y el ID

                    success: function (respuesta) {
                        if (respuesta.exito) {
                            fila.fadeOut(400, function () {
                                $(this).remove();
                            });

                            Swal.fire('Eliminado', respuesta.mensaje, 'success');
                        }
                    }
                });
            }
        });
    });

    // 5. EDITAR REGISTRO
    $(document).on('click', '.fa-pen-to-square', function () {
        let fila = $(this).closest('tr');
        let idAlumno = fila.find('td:eq(0)').text();
    
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
                $('#fecha_nac').val(alumno.FECHA_NAC);
                $('#edad').val(alumno.EDAD);
                $('#genero').val(alumno.GENERO);
                $('#direccion').val(alumno.DIRECCION);
                $('#celular').val(alumno.CELULAR);
                $('#correo').val(alumno.CORREO);
                $('#apoderado').val(alumno.APODERADO_NOMBRE);
                $('#cel_apoderado').val(alumno.APODERADO_CELULAR);
                $('#username').val(alumno.USERNAME);
    
                $('#modalAlumno').css('display', 'flex').hide().fadeIn();
            },
            error: function () {
                Swal.fire('Error', 'No se pudieron cargar los datos del alumno.', 'error');
            }
        });
    });
    $(document).on('click', '.btn-ver', function () {
        let fila = $(this).closest('tr');
        let idAlumno = fila.find('td:eq(0)').text();
    
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
                $('#ver_fecha_nac').val(alumno.FECHA_NAC);
                $('#ver_edad').val(alumno.EDAD);
                $('#ver_genero').val(alumno.GENERO);
                $('#ver_direccion').val(alumno.DIRECCION);
                $('#ver_celular').val(alumno.CELULAR);
                $('#ver_correo').val(alumno.CORREO);
                $('#ver_apoderado').val(alumno.APODERADO_NOMBRE);
                $('#ver_cel_apoderado').val(alumno.APODERADO_CELULAR);
                $('#ver_username').val(alumno.USERNAME);
                $('#ver_estado').val(alumno.estado);
    
                $('#modalVerAlumno').css('display', 'flex').hide().fadeIn();
            },
            error: function () {
                Swal.fire('Error', 'No se pudieron cargar los datos del alumno.', 'error');
            }
        });
    });


    /* ========================================================
       FUNCIÓN PARA CARGAR LA TABLA DESDE MYSQL
    ======================================================== */
    function cargarAlumnos() {
        $.ajax({
            url: "php/crud_alumnos.php",
            type: "POST",
            dataType: "json",
            data: { opcion: 4 }, // Le pedimos a PHP que ejecute el case 4

            success: function (data) {
                let tbody = $('#tablaAlumnos');
                tbody.empty(); // Limpiamos la tabla por si había algo antes

                // Recorremos cada alumno que llegó desde la base de datos
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
                            <td>${alumno.FECHA_NAC}</td>
                            <td>${alumno.CELULAR}</td>
                            <td>${alumno.CORREO}</td>status-active
                            <td><span class="status-badge ${statusClass[alumno.estado] || ""}">
                                ${alumno.estado}
                                </span></td>
                            <td class="action-icons">
                                <i class="fa-solid fa-pen-to-square "></i>
                                <i class="fa-solid fa-eye btn-ver"></i>
                                <i class="fa-solid fa-trash"></i>
                            </td>
                        </tr>
                    `;

                    // Agregamos la fila recién creada a la tabla
                    tbody.append(fila);
                });
            },

            error: function () {
                console.log("Error al cargar los datos de la tabla.");
            }
        });
    }

    // Ejecutar la función apenas cargue la página
    cargarAlumnos();
});