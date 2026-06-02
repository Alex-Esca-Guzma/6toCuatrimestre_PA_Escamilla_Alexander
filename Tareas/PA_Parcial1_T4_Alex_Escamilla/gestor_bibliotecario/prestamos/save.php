<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: index.php");
        exit;
    }   

    $id_usuario = intval($_POST["id_usuario"]);
    $id_libro = intval($_POST["id_libro"]);
    $fecha_prestamo = $_POST["fecha_prestamo"];
    $fecha_devolucion = $_POST["fecha_devolucion"];

    if ($fecha_prestamo === "" || $fecha_devolucion === "") {
        header("Location: create.php?error=" . urlencode("Las fechas son obligatorias"));
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO prestamos (id_usuario, fecha_prestamo, fecha_devolucion) VALUES(?, ?, ?)");
    $stmt->bind_param("iss", $id_usuario, $fecha_prestamo, $fecha_devolucion);

    if($stmt->execute()){

        $id_prestamo = $stmt->insert_id;

        $detalle = $conn->prepare("INSERT INTO detalle_prestamo (id_prestamo, id_libro, cantidad) VALUES(?, ?, 1)");
        $detalle->bind_param("ii", $id_prestamo, $id_libro);
        $detalle->execute();

        $update = $conn->prepare("UPDATE libros SET disponibles = disponibles - 1 WHERE id = ?");
        $update->bind_param("i", $id_libro);
        $update->execute();

        header("Location: index.php?success=" . urlencode("Préstamo creado exitosamente"));
    }else{
        header("Location: create.php?error=" . urlencode("Error al crear el préstamo: " . $stmt->error));
    }
?>