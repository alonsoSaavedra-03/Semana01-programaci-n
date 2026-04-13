<?php
header('Content-Type: application/json');
include("conexion.php");

$opcion = $_POST['opcion'] ?? '';

if ($opcion == "listar") {

    $sql = "SELECT 
                r.ID_RESERVA,
                CONCAT(a.NOMBRES, ' ', a.APELLIDOS) AS NOMBRE_ALUMNO,
                CONCAT(au.NIVEL, ' ', au.GRADO, ' ', au.SECCION) AS AULA,
                r.CODIGO_PAGO,
                r.FECHA_RESERVA,
                r.ESTADO_PAGOO,
                a.estado
            FROM RESERVA r
            INNER JOIN ALUMNO a ON r.ID_ALUMNO = a.ID_ALUMNO
            INNER JOIN AULA au ON r.ID_AULA = au.ID_AULA";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
}

if ($opcion == "aprobar") {

    $id_reserva = $_POST['idReserva'] ?? '';

    if (empty($id_reserva)) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "ID inválido"
        ]);
        exit;
    }

    $sql = "UPDATE RESERVA SET ESTADO_PAGOO = 'PAGADO' WHERE ID_RESERVA = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id_reserva])) {
        echo json_encode([
            "exito" => true,
            "mensaje" => "Pago aprobado."
        ]);
    } else {
        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al actualizar."
        ]);
    }
}

if ($opcion == "cancelar") {

    $id_reserva = $_POST['idReserva'] ?? '';

    if (empty($id_reserva)) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "ID inválido"
        ]);
        exit;
    }

    $sql = "UPDATE RESERVA SET ESTADO_PAGOO = 'CANCELADO' WHERE ID_RESERVA = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id_reserva])) {
        echo json_encode([
            "exito" => true,
            "mensaje" => "Pago cancelado."
        ]);
    } else {
        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al actualizar."
        ]);
    }
}

?>