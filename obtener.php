<?php 

include_once('./conexion.php');

$json = file_get_contents('php://input');

$datos = json_decode($json, true);

if($datos['id']){
    $database = new ConectarBD();
    $db = $database->open();
    $stmt = $db->prepare("SELECT * FROM personas WHERE id = :id");
    $stmt->bindValue(':id', $datos['id'], PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    echo json_encode($resultado);
}else{
    echo "No se obtuvo POST";
}
