<?php
require_once '../modelo/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

$iddepartamento = $_POST['tipo'];

if ($iddepartamento == 'todos') {

    $consulta = $mysql->efectuarConsulta("SELECT empleados.nombre, empleados.numDocumento, cargos.nombreCargo AS cargo, departamentos.nombreDepartamento AS departamento,empleados.salarioBase, empleados.fechaIngreso, empleados.estado FROM empleados INNER JOIN cargos ON empleados.cargo_id = cargos.IDcargo INNER JOIN departamentos ON empleados.departamento_id = departamentos.IDdepartamento WHERE empleados.estado = 'Activo'");
} else {
    $consulta = $mysql->efectuarConsulta("SELECT empleados.IDempleado, empleados.nombre, empleados.numDocumento, cargos.nombreCargo AS cargo, departamentos.nombreDepartamento AS departamento, empleados.salarioBase, empleados.fechaIngreso, empleados.estado FROM empleados INNER JOIN cargos ON empleados.cargo_id = cargos.IDcargo INNER JOIN departamentos ON empleados.departamento_id = departamentos.IDdepartamento WHERE empleados.departamento_id = $iddepartamento and empleados.estado = 'Activo'");
}
require_once '../views/generar_pdf.php';

$mysql->desconectar();
