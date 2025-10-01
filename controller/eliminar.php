<?php 
require_once '../modelo/MySQL.php';

$mysql = new MySQL();
$mysql->conectar();
//eliminacion de la persona
 $id=$_GET['id'];
    //consulta para traer los datos 
 


    $estado='Inactivo';
        $mysql->efectuarConsulta("UPDATE empleados 
            SET 
                estado='$estado'             WHERE id='$id'");
        $mysql->desconectar();

        header('location:../index.php');
        exit();
?>
