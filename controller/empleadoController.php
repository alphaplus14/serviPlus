<?php
require_once '../modelo/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

$iddepartamento = $_POST['tipo'];

if($iddepartamento=='todos'){

$consulta =$mysql->efectuarConsulta("SELECT empleados.nombre, empleados.identificacion, cargo.nombre AS cargo, departamento.nombre AS departamento,empleados.salario, empleados.fecha, empleados.estado FROM empleados INNER JOIN cargo ON empleados.cargo_id = cargo.id INNER JOIN departamento ON empleados.departamento_id = departamento.id WHERE empleados.estado = 'Activo'");
}
else{
 $consulta =$mysql->efectuarConsulta( "SELECT empleados.id, empleados.nombre, empleados.identificacion, cargo.nombre AS cargo, departamento.nombre AS departamento, empleados.salario, empleados.fecha, empleados.estado FROM empleados INNER JOIN cargo ON empleados.cargo_id = cargo.id INNER JOIN departamento ON empleados.departamento_id = departamento.id WHERE empleados.departamento_id = $iddepartamento and empleados.estado = 'Activo'");
}
require_once '../views/generar_pdf.php';

$mysql->desconectar();

?>
