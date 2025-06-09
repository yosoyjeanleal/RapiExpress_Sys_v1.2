<?php

use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;


session_start();

function auth_login() {
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->autenticar($username, $password);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['username'];
                $_SESSION['nombre_completo'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
                header('Location: index.php?c=dashboard&a=index');
                exit();
            } else {
                $error = "Credenciales inválidas.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }

    include __DIR__ . '/../views/auth/login.php';
}



function auth_recoverPassword() {
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $newPassword = trim($_POST['password'] ?? '');

        if (!empty($username) && !empty($newPassword)) {
            try {
                $conexionWrapper = new \RapiExpress\Config\ConexionWrapper();
$pdo = $conexionWrapper->getDb();

                
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateStmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE username = :username");
                    $updateStmt->execute([
                        'password' => $hashedPassword,
                        'username' => $username
                    ]);

                    $success = "Contraseña actualizada correctamente. Puedes iniciar sesión con tu nueva contraseña.";
                } else {
                    $error = "Usuario no encontrado.";
                }
            } catch (PDOException $e) {
                $error = "Error al conectar con la base de datos.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }

    include __DIR__ . '/../views/auth/recoverpassword.php';
}

function auth_logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php?c=auth&a=login');
    exit();
}
