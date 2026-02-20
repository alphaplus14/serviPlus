<?php
require_once '../modelo/MySQL.php';


//buena practica verificar el metodo y que no este vacio el id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $mysql = new MySQL();
    $mysql->conectar();

    $consulta = $mysql->efectuarConsulta("SELECT empleados.IDempleado, empleados.foto, empleados.nombre, empleados.numDocumento, empleados.cargo_id, cargos.nombreCargo AS cargo, empleados.departamento_id, departamento.nombreDepartamento AS area, empleados.fechaIngreso, empleados.salarioBase, empleados.estado, empleados.correoElectronico, empleados.telefono FROM empleados inner join cargos on empleados.cargo_id = cargos.IDcargo  inner join departamentos on empleados.departamento_id = departamentos.IDdepartamento where empleados.IDempleado=$id ");

    if ($consulta->num_rows > 0) {
        $informacion = $consulta->fetch_assoc();

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $informacion['id'],
                'foto' => $informacion['foto'],
                'nombre' => $informacion['nombre'],
                'documento' => $informacion['identificacion'],
                'cargo_id' => $informacion['cargo_id'],
                'cargo' => $informacion['cargo'],
                'departamento_id' => $informacion['departamento_id'],
                'area' => $informacion['area'],
                'fecha' => $informacion['fecha'],
                'salario' => $informacion['salario'],
                'estado' => $informacion['estado'],
                'correo' => $informacion['correo'],
                'telefono' => $informacion['telefono'],

            ]
        ]);
    } else {
        http_response_code(404);
        echo json_encode('error');
    }
    $mysql->desconectar();
}
