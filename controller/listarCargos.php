<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../modelo/MySQL.php'; 

$mysql = new MySQL();
$mysql->conectar();

// Consulta para obtener todos los cargos
$query = "SELECT id, nombre FROM cargo ORDER BY nombre ASC";
$resultado = $mysql->efectuarConsulta($query);

$cargos = [];
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $cargos[] = $fila;
    }
}

$mysql->desconectar();

// Devolver JSON
echo json_encode($cargos, JSON_UNESCAPED_UNICODE);
