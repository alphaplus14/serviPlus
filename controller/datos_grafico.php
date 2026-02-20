<?php
// Se incluye la conexión desde un controlador

require_once '../modelo/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

$consulta = $mysql->efectuarConsulta("SELECT departamentos.nombreDepartamento,count(*) as cantidad FROM empleados inner join departamentos on empleados.departamento_id=departamentos.IDdepartamento group by departamento_id");


$data = [];
while ($row = mysqli_fetch_assoc($consulta)) {
    $row["cantidad"] = (int)$row["cantidad"];
    $data[] = $row;
}

// Se devuelve en formato JSON
header('Content-Type: application/json');
echo json_encode($data);
$mysql->desconectar();
