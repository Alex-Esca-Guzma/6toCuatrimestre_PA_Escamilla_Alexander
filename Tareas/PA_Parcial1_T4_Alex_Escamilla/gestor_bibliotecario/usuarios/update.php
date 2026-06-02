<?php
// Modificado por Alex Escamilla

    require_once ("../config/connection.php");

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.php");
        exit;
    }

    $id = intval($_POST["id"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $contrasena = trim($_POST["contrasena"] ?? "");

    if ($id <= 0 || $nombre === "" || $apellido === "" || $contrasena === "") {
        header("Location: index.php?error=" . urlencode("Datos inválidos"));
        exit;
    }

    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, correo = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nombre, $apellido, $telefono, $correo, $contrasena, $id);
    if($stmt->execute()){
        header("Location: index.php?success=" . urlencode("Usuario actualizado exitosamente"));
        exit;
    } else {
        header("Location: index.php?error=" . urlencode("Error al actualizar el usuario: " . $stmt->error));
        exit;
    }
    $stmt->close();
    $conn->close();
?>