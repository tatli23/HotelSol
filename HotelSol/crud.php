<?php
include 'db_connection.php';
session_start();

function isFetchRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isFetchRequest()) {
    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => ''];

    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add':
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = trim($_POST['role'] ?? '');

            if (empty($username) || empty($password) || empty($role)) {
                $response['message'] = 'Todos los campos son obligatorios.';
            } else {
                try {
                    $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE nombre_usuario = ?");
                    $stmt->execute([$username]);

                    if ($stmt->rowCount() > 0) {
                        $response['message'] = 'El nombre de usuario ya está en uso.';
                    } else {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("INSERT INTO usuario (nombre_usuario, tipo, password) VALUES (?, ?, ?)");
                        $stmt->execute([$username, $role, $hashedPassword]);

                        $response['success'] = true;
                        $response['message'] = 'Usuario agregado exitosamente.';
                    }
                } catch (PDOException $e) {
                    $response['message'] = 'Error en base de datos: ' . $e->getMessage();
                }
            }
            break;

        case 'delete':
            $userId = intval($_POST['userId'] ?? 0);
            if ($userId <= 0) {
                $response['message'] = 'ID de usuario inválido.';
            } else {
                try {
                    $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = ?");
                    $stmt->execute([$userId]);

                    if ($stmt->rowCount() > 0) {
                        $response['success'] = true;
                        $response['message'] = 'Usuario eliminado correctamente.';
                    } else {
                        $response['message'] = 'Usuario no encontrado.';
                    }
                } catch (PDOException $e) {
                    $response['message'] = 'Error al eliminar: ' . $e->getMessage();
                }
            }
            break;

        case 'list':
            try {
                $stmt = $pdo->query("SELECT id_usuario, nombre_usuario, tipo AS rol FROM usuario");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response['success'] = true;
                $response['users'] = $users;
            } catch (PDOException $e) {
                $response['message'] = 'Error al listar usuarios: ' . $e->getMessage();
            }
            break;

        default:
            $response['message'] = 'Acción no válida.';
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Sol</title>
    <link rel="stylesheet" href="salidhues.css">
  <style>
       .user-management {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      margin-top: 20px;
    }
    
    .user-form {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(17,58,2,0.1);
    }
    
    .user-list-container {
      background: #f8f9fa;
      
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .user-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    
    .user-table th, .user-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    
    .user-table th {
      background-color: #17582aab;
      color: white;
    }
    
    .user-table tr:hover {
      background-color: #f1f1f1;
    }
    
    .btn-danger {
      background-color: #dc3545;
    }
    
    .btn-danger:hover {
      background-color: #c82333;
    }
    
    .message-success {
      color: #28a745;
      background-color: #d4edda;
      padding: 10px;
      border-radius: 4px;
      margin: 10px 0;
      text-align: center;
    }
    
    .message-error {
      color: #dc3545;
      background-color: #f8d7da;
      padding: 10px;
      border-radius: 4px;
      margin: 10px 0;
      text-align: center;
    }
    
    @media (max-width: 768px) {
      .user-management {
        grid-template-columns: 1fr;
      }
    }

     table {
      width: 100%; border-collapse: collapse; margin-top: 30px;
      background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px 15px; border: 1px solid #ddd; text-align: left;
    }
    th {
      background-color: #17582bd3; color: white;
      font-weight: normal;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  
  </style>
</head>
<body class= "index">

<header>
     <h1>Hotel el Sol</h1>
    </header>

      <section class='hero'>
    <div >
      <h2>Gestión de Usuarios</h2>
      <p><strong></strong></p>
    </div>
  </section>

    
<section   class="module-screen" >
    <div class="user-form">
  <h2>Agregar Usuario</h2>
  <form id="addUserForm">
    <label>Nombre de usuario:
      <input type="text" id="username" required />
    </label>
    <label>Contraseña:
      <input type="password" id="password" required />
    </label>
    <label>Rol:
      <select  class="form-control" id="role" required> 
        <option value="">Seleccionar</option>
        <option value="admin">Administrador</option>
        <option value="recepcionista">Recepcionista</option>
      </select>
    </label>
    <button class="btn"  type="submit">Agregar</button>
  </form>
  </formid>
    </div>


  <p id="message"></p>

  <div >
  <h2>Lista de Usuarios</h2>
  <table id="usersTable">
    <thead>
      <tr>
        <!--<th>ID</th>-->
        <th>Nombre de Usuario</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  </div>
  <div class="navigation">
            <button class="btn btn-secondary" onclick="window.location.href='administrador.php'">Regresar</button>
        </div>
</section>

          

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('addUserForm');
      const message = document.getElementById('message');
      const tableBody = document.querySelector('#usersTable tbody');

      loadUsers();

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        const role = document.getElementById('role').value;

        fetch('crud.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: new URLSearchParams({
            action: 'add',
            username,
            password,
            role
          })
        })
        .then(res => res.json())
        .then(data => {
          message.textContent = data.message;
          message.className = data.success ? 'success' : 'error';
          if (data.success) {
            form.reset();
            loadUsers();
          }
        });
      });

      function loadUsers() {
        fetch('crud.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: new URLSearchParams({ action: 'list' })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            tableBody.innerHTML = '';
            data.users.forEach(user => {
              const row = document.createElement('tr');
              row.innerHTML = `
                
                <td>${user.nombre_usuario}</td>
                <td>${user.rol}</td>
                <td><button onclick="deleteUser(${user.id_usuario})">Eliminar</button></td>
              `;
              tableBody.appendChild(row);
            });
          }
        });
      }

      window.deleteUser = function (userId) {
        if (!confirm('¿Estás seguro de eliminar este usuario?')) return;

        fetch('crud.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: new URLSearchParams({
            action: 'delete',
            userId
          })
        })
        .then(res => res.json())
        .then(data => {
          message.textContent = data.message;
          message.className = data.success ? 'success' : 'error';
          if (data.success) {
            loadUsers();
          }
        });
      };
    });
  </script>

   <footer>
    <p>&copy; <?php echo date("Y"); ?> Hotel Sol. Todos los derechos reservados.</p>
  </footer>

</body>
</html>
