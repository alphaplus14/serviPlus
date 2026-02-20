<?php

header('Content-Type: application/json; charset=utf-8');

require_once '../modelo/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();

// Consulta para obtener todos los departamentos
$query = "SELECT IDdepartamento, nombreDepartamento FROM departamentos ORDER BY nombreDepartamento ASC";
$resultado = $mysql->efectuarConsulta($query);

$departamentos = [];
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $departamentos[] = $fila;
    }
}

$mysql->desconectar();

// Devolver JSON
echo json_encode($departamentos, JSON_UNESCAPED_UNICODE);
