<?php
header('Content-Type: application/json');
include("conexion.php");

$opcion = $_POST['opcion'] ?? '';

if ($opcion == "listarmatricula") {

    $sql = "SELECT 
                a.ID_ALUMNO,
                CONCAT(a.NOMBRES, ' ', a.APELLIDOS) AS ESTUDIANTE,
                a.DNI_ALUMNO,
                a.CELULAR,
                m.ESTADO_MATRICULA,
                CASE 
                    WHEN m.ID_MATRICULA IS NULL THEN 'Sin matricula'
                    ELSE CONCAT(au.NIVEL, ' ', au.GRADO, '° ', au.SECCION)
                END AS MATRICULA_ACTUAL,
                a.ESTADO
            FROM ALUMNO a
            LEFT JOIN MATRICULA m 
                ON a.ID_ALUMNO = m.ID_ALUMNO 
                AND m.ANIO_ESCOLAR = YEAR(CURDATE())
            LEFT JOIN AULA au 
                ON m.ID_AULA = au.ID_AULA";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
}

if ($opcion == "aprobarMatricula") {

    $id_alumno = $_POST['idAlumno'] ?? '';
    $nivel = $_POST['nivel'] ?? '';
    $grado = $_POST['grado'] ?? '';

    if (empty($id_alumno) || empty($nivel) || empty($grado)) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "Faltan datos."
        ]);
        exit;
    }

    $sqlVerificar = "SELECT ID_MATRICULA
                     FROM MATRICULA
                     WHERE ID_ALUMNO = ? AND ANIO_ESCOLAR = YEAR(CURDATE())";
    $stmtVerificar = $pdo->prepare($sqlVerificar);
    $stmtVerificar->execute([$id_alumno]);

    if ($stmtVerificar->fetch()) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "El alumno ya tiene matrícula este año."
        ]);
        exit;
    }

    $sqlAula = "SELECT ID_AULA
                FROM AULA
                WHERE LOWER(NIVEL) = LOWER(?) AND GRADO = ?
                LIMIT 1";
    $stmtAula = $pdo->prepare($sqlAula);
    $stmtAula->execute([$nivel, $grado]);
    $aula = $stmtAula->fetch(PDO::FETCH_ASSOC);

    if (!$aula) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "No se encontró aula para ese nivel y grado."
        ]);
        exit;
    }

    $id_aula = $aula['ID_AULA'];

    try {
        $pdo->beginTransaction();

        $sqlMatricula = "INSERT INTO MATRICULA
                        (ID_ALUMNO, ID_AULA, FECHA_MATRICULA, ANIO_ESCOLAR, ESTADO_MATRICULA)
                        VALUES (?, ?, NOW(), YEAR(CURDATE()), 'ACTIVO')";
        $stmtMatricula = $pdo->prepare($sqlMatricula);
        $stmtMatricula->execute([$id_alumno, $id_aula]);

        $codigo_pago = "PAGO" . str_pad($id_alumno, 3, "0", STR_PAD_LEFT);

        $sqlReserva = "INSERT INTO RESERVA
                      (ID_ALUMNO, ID_AULA, CODIGO_PAGO, FECHA_RESERVA, ESTADO_PAGOO)
                      VALUES (?, ?, ?, NOW(), 'PENDIENTE')";
        $stmtReserva = $pdo->prepare($sqlReserva);
        $stmtReserva->execute([$id_alumno, $id_aula, $codigo_pago]);

        $pdo->commit();

        echo json_encode([
            "exito" => true,
            "mensaje" => "Matrícula y reserva registradas correctamente."
        ]);

    } catch (Exception $e) {
        $pdo->rollBack();

        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al registrar matrícula y reserva."
        ]);
    }
}

if ($opcion == "cancelarMatricula") {

    $id_alumno = $_POST['idAlumno'] ?? '';

    if (empty($id_alumno)) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "ID inválido"
        ]);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $sqlMatricula = "DELETE FROM MATRICULA 
                 WHERE ID_ALUMNO = ? 
                 AND ANIO_ESCOLAR = YEAR(CURDATE())";
        $stmtMatricula = $pdo->prepare($sqlMatricula);
        $stmtMatricula->execute([$id_alumno]);

        $sqlReserva = "DELETE FROM RESERVA 
                       WHERE ID_ALUMNO = ?";
        $stmtReserva = $pdo->prepare($sqlReserva);
        $stmtReserva->execute([$id_alumno]);

        $pdo->commit();

        echo json_encode([
            "exito" => true,
            "mensaje" => "Matrícula cancelada y reserva eliminada correctamente."
        ]);

    } catch (Exception $e) {
        $pdo->rollBack();

        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al cancelar la matrícula."
        ]);
    }
}
?>