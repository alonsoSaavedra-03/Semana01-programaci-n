<?php
header('Content-Type: application/json');
include("conexion.php");

if (!isset($pdo)) {
    echo json_encode(["exito" => false, "mensaje" => "Error de conexión"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["exito" => false, "mensaje" => "Método no permitido"]);
    exit;
}

$opcion = $_POST['opcion'] ?? '';

switch ($opcion) {

    case 'listadoAulas':
        $sql = "SELECT * FROM AULA";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo json_encode([
            "exito" => true,
            "datos" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
    break;

    case 'obtenerAula':
        $id = $_POST['id_aula'] ?? $_POST['idAula'] ?? '';

        $sql = "SELECT * FROM AULA WHERE ID_AULA = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $aula = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aula) {
            echo json_encode([
                "exito" => true,
                "datos" => $aula
            ]);
        } else {
            echo json_encode([
                "exito" => false,
                "mensaje" => "Aula no encontrada"
            ]);
        }
    break;

    case 'agregarAula':
    case 'insertarAula':
        $id = $_POST['idAula'] ?? $_POST['id_aula'] ?? '';

        $nivel = $_POST['nombreAula'] ?? '';
        $grado = $_POST['capacidadAula'] ?? '';
        $seccion = $_POST['seccionAula'] ?? '';
        $vacantesTotales = $_POST['vacantesTotales'] ?? '';
        $vacantesDisponibles = $_POST['vacantesAula'] ?? '';

        if (!empty($id)) {
            $sql = "UPDATE AULA
                    SET NIVEL=?, GRADO=?, SECCION=?, VACANTES_TOTALES=?, VACANTES_DISPONIBLES=?
                    WHERE ID_AULA=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nivel, $grado, $seccion, $vacantesTotales, $vacantesDisponibles, $id]);

            echo json_encode([
                "exito" => true,
                "mensaje" => "Aula actualizada"
            ]);
        } else {
            $sql = "INSERT INTO AULA (NIVEL, GRADO, SECCION, VACANTES_TOTALES, VACANTES_DISPONIBLES)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$nivel, $grado, $seccion, $vacantesTotales, $vacantesDisponibles])) {
                echo json_encode([
                    "exito" => true,
                    "mensaje" => "Aula registrada correctamente"
                ]);
            } else {
                echo json_encode([
                    "exito" => false,
                    "mensaje" => "Error al registrar aula"
                ]);
            }
        }
    break;

    case 'editarAula':
        $id = $_POST['idAula'] ?? $_POST['id_aula'] ?? '';

        $nivel = $_POST['nombreAula'] ?? '';
        $grado = $_POST['capacidadAula'] ?? '';
        $seccion = $_POST['seccionAula'] ?? '';
        $vacantesTotales = $_POST['vacantesTotales'] ?? '';
        $vacantesDisponibles = $_POST['vacantesAula'] ?? '';

        $sql = "UPDATE AULA
                SET NIVEL=?, GRADO=?, SECCION=?, VACANTES_TOTALES=?, VACANTES_DISPONIBLES=?
                WHERE ID_AULA=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nivel, $grado, $seccion, $vacantesTotales, $vacantesDisponibles, $id]);

        echo json_encode([
            "exito" => true,
            "mensaje" => "Aula actualizada"
        ]);
    break;

    case 'eliminarAula':
        $id = $_POST['idAula'] ?? $_POST['id_aula'] ?? '';

        $sql = "DELETE FROM AULA WHERE ID_AULA = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode([
                "exito" => true,
                "mensaje" => "Aula eliminada"
            ]);
        } else {
            echo json_encode([
                "exito" => false,
                "mensaje" => "No se eliminó"
            ]);
        }
    break;

    default:
        echo json_encode([
            "exito" => false,
            "mensaje" => "Operación no válida"
        ]);
    break;
}
?>