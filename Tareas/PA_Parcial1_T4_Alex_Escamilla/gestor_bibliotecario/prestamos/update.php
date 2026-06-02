<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: index.php");
        exit;
    }   

    $id = intval($_POST["id"]);
    $fecha_devolucion = $_POST["fecha_devolucion"];
    $estado = $_POST["estado"];

    $stmt = $conn->prepare("UPDATE prestamos SET fecha_devolucion = ?, estado = ? WHERE id = ?");
    $stmt->bind_param("ssi", $fecha_devolucion, $estado, $id);

    if($stmt->execute()){
        header("Location:index.php?success=".urlencode("Préstamo actualizado correctamente"));
        exit();
    }else{
        header("Location:index.php?error=".urlencode("Error al actualizar el préstamo"));
        exit();
    }
    $stmt->close();
    $conn->close();
?>