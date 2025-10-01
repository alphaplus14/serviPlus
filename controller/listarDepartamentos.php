<?php
// listarDepartamentos.php
header('Content-Type: application/json; charset=utf-8');

require_once '../modelo/MySQL.php'; // Ajusta la ruta según tu proyecto

$mysql = new MySQL();
$mysql->conectar();

// Consulta para obtener todos los departamentos
$query = "SELECT id, nombre FROM departamento ORDER BY nombre ASC";
$resultado = $mysql->efectuarConsulta($query);

$departamentos = [];
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $departamentos[] = $fila;
    }
}

// Cerrar conexión
$mysql->desconectar();

// Devolver JSON
echo json_encode($departamentos, JSON_UNESCAPED_UNICODE);
