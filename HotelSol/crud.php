<?php
include 'db_connection.php';
session_start();


$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $nombre_usuario = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['role'] ?? '';

    if ($nombre_usuario && $password && $rol) {
        $tipo = ($rol === 'admin') ? 1 : 2;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO usuario (nombre_usuario, password, tipo, fecha_registro) VALUES (?, ?, ?, NOW())");
            if ($stmt->execute([$nombre_usuario, $hashedPassword, $tipo])) {
                echo json_encode(["success" => true, "message" => "Usuario creado exitosamente."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al insertar usuario."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos."]);
    }

} elseif ($action === 'delete') {
    $id = $_POST['id'] ?? '';
    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = ?");
            if ($stmt->execute([$id])) {
                echo json_encode(["success" => true, "message" => "Usuario eliminado."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al eliminar usuario."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "ID no válido."]);
    }

} elseif ($action === 'list') {
    try {
        $stmt = $pdo->query("SELECT id_usuario, nombre_usuario, tipo FROM usuario");
        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['rol'] = ($row['tipo'] == 1) ? 'Administrador' : 'Recepcionista';
            $usuarios[] = $row;
        }
        echo json_encode(["success" => true, "users" => $usuarios]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Sol</title>
  <link rel="stylesheet" href="salidhues.css">

</head>

<body class="index">

    <header>
     <h1>Hotel el Sol</h1>
    </header>

    <section>
    <div>
      <h2 class="menu"><strong>Gestión de Usuarios </strong></h2>
    </div>
  </section>

<div class="module-screen" id="usuarios">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h3>Agregar Usuario</h3>
                    <div class="form-group">
                        <label>Usuario:</label>
                        <input type="text" id="newUsername" placeholder="Nombre de usuario">
                    </div>
                    <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" id="newPassword" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <label>Rol:</label>
                        <select id="newRole">
                            <option value="recepcionista">Recepcionista</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <button class="btn" onclick="addUser()">Agregar Usuario</button>
                </div>
                <div>
                    <h3>Usuarios del Sistema</h3>
                    <div id="usersList" class="user-list"></div>
                </div>
            </div>
            <div id="userMessage" style="margin: 1rem 0;"></div>
            <div class="navigation">
                <button class="btn btn-secondary" onclick="window.location.href='administrador.php'">Regresar</button>
            </div>
        </div>
    </div>
</body>
</html>