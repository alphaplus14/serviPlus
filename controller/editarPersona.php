<?php 
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

session_start();

if (!isset($_SESSION['cargo'])){
  echo json_encode(["success" => false, "message" => "Sesión no válida"]);
  exit();
}
//conexion 
require_once '../modelo/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit();
}

// Traer foto actual para poder reemplazarla si se sube una nueva
$sql = $mysql->efectuarConsulta("SELECT foto FROM empleados WHERE id='$id'");

if($sql->num_rows > 0){ $row = $sql->fetch_assoc(); $fotoActual= $row['foto'];
}

$nombre        = $_POST['nombre'];
$passwordOld   = $_POST['passwordOld']; 
$passwordNueva = $_POST['passwordNueva'];
$cargo         = $_POST['cargo'];
$area          = $_POST['area'];
$fecha_ingreso = $_POST['fecha'];
$salario       = $_POST['salario'];
$correo        = $_POST['correo'];
$telefono      = $_POST['telefono'];

// Manejo de imagen 
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $tipo = mime_content_type($_FILES['imagen']['tmp_name']);
    $ext = ($tipo === 'image/png') ? '.png' : '.jpg';
    $nombreUnico = 'imagen_' . date('Ymd_Hisv') . $ext;
    $ruta = 'assets/fotos/' . $nombreUnico;
    $rutaAbsoluta = __DIR__ . '/../' . $ruta;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaAbsoluta)) {
        $anteriorAbsoluta = __DIR__ . '/' . $fotoActual;
        if ($fotoActual && file_exists($anteriorAbsoluta)) {
            unlink($anteriorAbsoluta);
        }
        $fotoActual = $ruta;
    }
}

if (!empty($passwordNueva)) {

    //validar la contraseña vieja 
    if (!password_verify($passwordOld, $row['password'])) {
        echo json_encode(["success" => false, "message" => "La contraseña actual no coincide"]);
        exit();
    }
//si coincide actuliza por la nueva
    $passwordNuevaHash = password_hash($passwordNueva, PASSWORD_BCRYPT);
    $consulta = "UPDATE empleados 
        SET foto='$fotoActual', 
            nombre='$nombre',
            password='$passwordNuevaHash',
            cargo_id='$cargo', 
            departamento_id='$area', 
            fecha='$fecha_ingreso',
            salario='$salario', 
            correo='$correo', 
            telefono='$telefono'
        WHERE id='$id'";
} else {
    //si no actualiza queda la misma

    $consulta = "UPDATE empleados 
        SET foto='$fotoActual', 
            nombre='$nombre',
            cargo_id='$cargo', 
            departamento_id='$area', 
            fecha='$fecha_ingreso',
            salario='$salario', 
            correo='$correo', 
            telefono='$telefono'
        WHERE id='$id'";
}

$result = $mysql->efectuarConsulta($consulta);

if ($result === true) {
    echo json_encode(["success" => true, "message" => "Empleado actualizado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar"]);
}

$mysql->desconectar();
