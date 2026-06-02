<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    $id = intval($_GET["id"]);

    $stmtDetalle = $conn->prepare("SELECT id_libro FROM detalle_prestamo WHERE id_prestamo = ?");
    $stmtDetalle->bind_param("i", $id);
    $stmtDetalle->execute();

    $resultado = $stmtDetalle->get_result();

    while($row = $resultado->fetch_assoc()){

        $update = $conn->prepare("UPDATE libros SET disponibles = disponibles + 1 WHERE id = ?");
        $update->bind_param("i", $row["id_libro"]);
        $update->execute();
    }

    $stmtDetalle = $conn->prepare("DELETE FROM detalle_prestamo WHERE id_prestamo = ?");
    $stmtDetalle->bind_param("i", $id);
    $stmtDetalle->execute();

    $stmt = $conn->prepare("DELETE FROM prestamos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location:index.php?success=".urlencode("Préstamo eliminado correctamente"));
        exit();
    }else{
        header("Location:index.php?error=".urlencode("Error al eliminar el préstamo"));
        exit();
    }
    $stmt->close(); 
    $conn->close();
?>