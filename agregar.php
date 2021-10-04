<?php

session_start();

include_once('./conexion.php');

if(isset($_POST['agregar'])){
    $database = new ConectarBD();
    $db = $database->open();
    try{
        $stmt = $db->prepare("INSERT INTO personas (nombre, telefono, correo, direccion) 
            VALUES(:nombre,:telefono,:email,:direccion)");
        $_SESSION['message'] = (
            $stmt->execute(
                array(
                    ':nombre' => $_POST['nombre'],
                    ':telefono' => $_POST['telefono'],
                    ':email' => $_POST['email'],
                    ':direccion' => $_POST['direccion'],
                )
            )
        ) ? 'Contacto Agregado correctamente' : 'Algo salio mal, intente nuevamente';
    }catch(Exception $e){
        $_SESSION['message'] = 'Error al Agregar: ' . $e->getMessage();
    }
}else if(isset($_POST['editar'])){
    $database = new ConectarBD();
    $db = $database->open();
    try{
        $stmt = $db->prepare("UPDATE personas SET nombre = :nombre, telefono = :telefono, correo = :email, direccion = :direccion WHERE id = :id");
        $_SESSION['message'] = (
            $stmt->execute(
                array(
                    ':nombre' => $_POST['nombre'],
                    ':telefono' => $_POST['telefono'],
                    ':email' => $_POST['email'],
                    ':direccion' => $_POST['direccion'],
                    ':id' => $_POST['id'],
                )
            )
        ) ? 'Contacto Actualizado correctamente' : 'Algo salio mal, intente nuevamente';
                }catch(PDOException $e){
                    $_SESSION['message'] = 'Error al actualizar' . $e->getMessage();
                }
}else{
    $_SESSION['message'] = "Datos proporcionados incorrectos";
}

header('Location: index.php');

?>