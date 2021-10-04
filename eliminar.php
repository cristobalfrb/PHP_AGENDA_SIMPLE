<?php 

include_once('./conexion.php');

if(isset($_GET['id'])){
    $database = new ConectarBD();
    $db = $database->open();
    try{
        $stmt = $db->prepare("DELETE FROM personas WHERE id = :id");
        $_SESSION['message'] = ($stmt->execute(array(':id' => $_GET['id']))) ? 'Registro Eliminado Correctamente' : 'Hubo un error en la eliminacion';

    }catch(PDOException $e){
        $_SESSION['message'] = $e->getMessage();
    }
}else{
    $_SESSION['message'] = "Informacion Erronea";
}
header('location: index.php');

?>