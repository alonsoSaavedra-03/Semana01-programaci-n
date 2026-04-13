<?php
header('Content-Type: application/json');

include("conexion.php");

try {

    $opcion = $_POST['opcion'] ?? '';

    switch ($opcion) {

        case '1': // CREAR
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO ALUMNO (
                        DNI_ALUMNO,
                        NOMBRES,
                        APELLIDOS,
                        FECHA_NACIMIENTO,
                        EDAD,
                        GENERO,
                        DIRECCION,
                        CELULAR,
                        CORREO,
                        NOMBRE_APODERADO,
                        CELULAR_APODERADO,
                        USERNAME,
                        PASSWORD_HASH,
                        estado
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_POST['dni'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['fecha_nac'],
                $_POST['edad'],
                $_POST['genero'],
                $_POST['direccion'],
                $_POST['celular'],
                $_POST['correo'],
                $_POST['apoderado'],
                $_POST['cel_apoderado'],
                $_POST['username'],
                $hash,
                $_POST['estado']
            ]);

            echo json_encode([
                "exito" => true,
                "mensaje" => "Alumno registrado correctamente."
            ]);
            break;

        case '2': // EDITAR
            if (!empty($_POST['password'])) {
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $sql = "UPDATE ALUMNO SET
                            DNI_ALUMNO = ?,
                            NOMBRES = ?,
                            APELLIDOS = ?,
                            FECHA_NACIMIENTO = ?,
                            EDAD = ?,
                            GENERO = ?,
                            DIRECCION = ?,
                            CELULAR = ?,
                            CORREO = ?,
                            NOMBRE_APODERADO = ?,
                            CELULAR_APODERADO = ?,
                            USERNAME = ?,
                            PASSWORD_HASH = ?,
                            estado = ?
                        WHERE ID_ALUMNO = ?";

                $params = [
                    $_POST['dni'],
                    $_POST['nombres'],
                    $_POST['apellidos'],
                    $_POST['fecha_nac'],
                    $_POST['edad'],
                    $_POST['genero'],
                    $_POST['direccion'],
                    $_POST['celular'],
                    $_POST['correo'],
                    $_POST['apoderado'],
                    $_POST['cel_apoderado'],
                    $_POST['username'],
                    $hash,
                    $_POST['estado'],
                    $_POST['id_alumno']
                ];
            } else {
                $sql = "UPDATE ALUMNO SET
                            DNI_ALUMNO = ?,
                            NOMBRES = ?,
                            APELLIDOS = ?,
                            FECHA_NACIMIENTO = ?,
                            EDAD = ?,
                            GENERO = ?,
                            DIRECCION = ?,
                            CELULAR = ?,
                            CORREO = ?,
                            NOMBRE_APODERADO = ?,
                            CELULAR_APODERADO = ?,
                            USERNAME = ?,
                            estado = ?
                        WHERE ID_ALUMNO = ?";

                $params = [
                    $_POST['dni'],
                    $_POST['nombres'],
                    $_POST['apellidos'],
                    $_POST['fecha_nac'],
                    $_POST['edad'],
                    $_POST['genero'],
                    $_POST['direccion'],
                    $_POST['celular'],
                    $_POST['correo'],
                    $_POST['apoderado'],
                    $_POST['cel_apoderado'],
                    $_POST['username'],
                    $_POST['estado'],
                    $_POST['id_alumno']
                ];
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            echo json_encode([
                "exito" => true,
                "mensaje" => "Datos actualizados correctamente."
            ]);
            break;

        case '3': // ELIMINAR
            $sql = "DELETE FROM ALUMNO WHERE ID_ALUMNO = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['id_alumno']]);

            echo json_encode([
                "exito" => true,
                "mensaje" => "Registro eliminado."
            ]);
            break;

        case '4': // LISTAR
            $sql = "SELECT
                        ID_ALUMNO,
                        NOMBRES,
                        APELLIDOS,
                        DNI_ALUMNO,
                        FECHA_NACIMIENTO,
                        CELULAR,
                        CORREO,
                        estado,
                        FECHA_REGISTRO
                    FROM ALUMNO
                    ORDER BY ID_ALUMNO DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($alumnos);
            break;

        case '5': // OBTENER UNO
            $sql = "SELECT
                        ID_ALUMNO,
                        DNI_ALUMNO,
                        NOMBRES,
                        APELLIDOS,
                        FECHA_NACIMIENTO,
                        EDAD,
                        GENERO,
                        DIRECCION,
                        CELULAR,
                        CORREO,
                        NOMBRE_APODERADO,
                        CELULAR_APODERADO,
                        USERNAME,
                        estado
                    FROM ALUMNO
                    WHERE ID_ALUMNO = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['id_alumno']]);

            $alumno = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($alumno);
            break;

        default:
            echo json_encode([
                "exito" => false,
                "mensaje" => "Opción no válida."
            ]);
            break;
    }

} catch (PDOException $e) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Error BD: " . $e->getMessage()
    ]);
}
?>