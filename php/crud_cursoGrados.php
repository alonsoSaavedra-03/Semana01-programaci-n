<?php
header('Content-Type: application/json');
include("conexion.php");

$opcion = $_POST['opcion'] ?? '';

switch ($opcion) {
    case 'listadoCursos':
        obtenerCursos($pdo);
        break;

    case 'insertarCurso':
        insertarCurso($pdo);
        break;

        case 'eliminarCurso':
            $id = $_POST['id'] ?? '';
            try {
                $sql = "DELETE FROM curso WHERE ID_CURSO = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                
                echo json_encode(["exito" => true, "mensaje" => "Curso eliminado correctamente"]);
            } catch (PDOException $e) {
                echo json_encode(["exito" => false, "mensaje" => "Error: " . $e->getMessage()]);
            }
            break;
        case 'editarCurso':
                $id = $_POST['idCurso'];
                $nombre = $_POST['nombreCurso'];
                $desc = $_POST['descripcionCurso'];
                $horas = $_POST['horasCurso'];
            
                $sql = "UPDATE curso SET NOMBRE = :nombre, DESCRIPCION = :desc, HORAS_SEMANA = :horas WHERE ID_CURSO = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':desc' => $desc,
                    ':horas' => $horas,
                    ':id' => $id
                ]);
            
                echo json_encode(["exito" => true, "mensaje" => "Curso actualizado"]);
                break;

    default:
        echo json_encode(["exito" => false, "mensaje" => "Operación no válida"]);
        break;
}

function obtenerCursos($pdo) {
    $sql = "SELECT * FROM curso";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

function insertarCurso($pdo) {
    $nombreCurso = $_POST['nombreCurso'] ?? '';
    $horasCurso = $_POST['horasCurso'] ?? '';
    $descripcionCurso = $_POST['descripcionCurso'] ?? '';

    // Validación básica
    if (empty($nombreCurso) || empty($descripcionCurso)) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "El nombre y la descripción son obligatorios"
        ]);
        return;
    }

    try {
        $sql = "INSERT INTO curso (NOMBRE, DESCRIPCION, HORAS_SEMANA) VALUES (:nombre, :descripcion, :horas_semana)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombre' => $nombreCurso,
            ':descripcion' => $descripcionCurso,
            ':horas_semana' => $horasCurso
        ]);

        echo json_encode([
            "exito" => true,
            "mensaje" => "Curso agregado correctamente"
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al insertar: " . $e->getMessage()
        ]);
    }
}
?>