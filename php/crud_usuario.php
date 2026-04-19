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

    case 'listarUsuarios':

        $sql = "SELECT * FROM usuario";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($usuarios);
        } else {
            echo json_encode(["exito" => false, "mensaje" => "Error al listar usuarios"]);
        }

    break;

    case 'insertarUsuario':

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $estado = $_POST['estado'] ?? 1;

        if (empty($username) || empty($password)) {
            echo json_encode(["exito" => false, "mensaje" => "Datos incompletos"]);
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (USERNAME, PASSWORD_HASH, ESTADO)
                VALUES (?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$username, $passwordHash, $estado])) {
            echo json_encode(["exito" => true, "mensaje" => "Usuario registrado"]);
        } else {
            echo json_encode(["exito" => false, "mensaje" => "Error al registrar"]);
        }

    break;

    case 'obtenerUsuario':

        $id = $_POST['idUsuario'] ?? 0;

        $sql = "SELECT * FROM usuario WHERE ID = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$id])) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($usuario);
        } else {
            echo json_encode(["exito" => false, "mensaje" => "Error al obtener usuario"]);
        }

    break;

    case 'editarUsuario':

        $id = $_POST['idUsuario'] ?? 0;
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $estado = $_POST['estado'] ?? 1;

        if (empty($username)) {
            echo json_encode(["exito" => false, "mensaje" => "Username requerido"]);
            exit;
        }

        if (!empty($password)) {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE usuario 
                    SET USERNAME = ?, PASSWORD_HASH = ?, ESTADO = ?
                    WHERE ID = ?";

            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([$username, $passwordHash, $estado, $id]);

        } else {
            $sql = "UPDATE usuario 
                    SET USERNAME = ?, ESTADO = ?
                    WHERE ID = ?";

            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([$username, $estado, $id]);
        }

        if ($ok) {
            echo json_encode(["exito" => true, "mensaje" => "Usuario actualizado"]);
        } else {
            echo json_encode(["exito" => false, "mensaje" => "Error al actualizar"]);
        }

    break;

    case 'eliminarUsuario':

        $id = $_POST['idUsuario'] ?? 0;

        $sql = "DELETE FROM usuario WHERE ID = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$id])) {
            echo json_encode(["exito" => true, "mensaje" => "Usuario eliminado"]);
        } else {
            echo json_encode(["exito" => false, "mensaje" => "Error al eliminar"]);
        }

    break;

    default:
        echo json_encode(["exito" => false, "mensaje" => "Operación no válida"]);
}
?>