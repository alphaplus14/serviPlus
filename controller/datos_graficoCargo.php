<?php
// Se incluye la conexión desde un controlador

require_once '../modelo/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

$consulta = $mysql->efectuarConsulta("SELECT cargos.nombreCargo,count(*) as cantidad FROM empleados inner join cargos on empleados.cargo_id=cargos.IDcargo group by cargo_id");


$data = [];
while ($row = mysqli_fetch_assoc($consulta)) {
    $row["cantidad"] = (int)$row["cantidad"];
    $data[] = $row;
}

// Se devuelve en formato JSON
header('Content-Type: application/json');
echo json_encode($data);
$mysql->desconectar();
