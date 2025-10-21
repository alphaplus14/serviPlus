<?php 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once '../modelo/MySQL.php';
session_start();

if (isset($_POST['cedula']) && !empty($_POST['cedula']) && 
    isset($_POST['password']) && !empty($_POST['password'])) {

    $mysql = new MySQL();
    $mysql->conectar();

    // Sanitizar datos
    $identificacion = htmlspecialchars(trim($_POST['cedula']), ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    // Consulta del usuario
    $resultado = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE identificacion='".$identificacion."'");
    $usuarios = mysqli_fetch_assoc($resultado);
    $mysql->desconectar(); 

    if ($usuarios) {

        // Verificar estado
        if ($usuarios['estado'] === 'Inactivo') {
            echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Usuario inactivo',
                    text: 'No tiene permiso de acceso.'
                }).then(() => {
                    window.location = '../views/login.php';
                });
                </script>
            </body>
            </html>";
            exit();
        }

        // Verificar contraseña
        if (password_verify($password, $usuarios['password'])) {
            // Guardar sesión
            $_SESSION['usuario_id'] = $usuarios['id'];
            $_SESSION['identificacion'] = $usuarios['identificacion'];
            $_SESSION['cargo'] = $usuarios['cargo_id'];
            $_SESSION['nombre_usuario'] = $usuarios['nombre'];
            $_SESSION['fotoPerfil'] = $usuarios['foto'];
            $_SESSION['fecha'] = $usuarios['fecha'];

            // SweetAlert de bienvenida
            echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Bienvenido',
                    text: 'Hola, ".$usuarios['nombre']."',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location = '../index.php';
                });
                </script>
            </body>
            </html>";
            exit();
        } else {
            echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseña incorrecta',
                    text: 'Por favor, inténtalo nuevamente.'
                }).then(() => {
                    window.location = '../views/login.php';
                });
                </script>
            </body>
            </html>";
            exit();
        }

    } else {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Usuario no encontrado',
                text: 'Verifica la cédula e inténtalo de nuevo.'
            }).then(() => {
                window.location = '../views/login.php';
            });
            </script>
        </body>
        </html>";
        exit();
    }

} else {
    header('Location: ../views/login.php');
    exit();
}
?>
