<?php
// Modificado por Alex Escamilla

    require_once("../config/connection.php");

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        header("Location: index.php");
        exit;
    }   

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $contrasena = trim($_POST["contrasena"] ?? "");
    $id_rol = 1;

    if ($nombre === "" || $contrasena === "") {
        header("Location: create.php?error=" . urlencode("El nombre y contraseña son obligatorios"));
    }

    $stmt=$conn->prepare("INSERT INTO usuarios (nombre, apellido, telefono, correo, password, id_rol) VALUES(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nombre, $apellido, $telefono, $correo, $contrasena, $id_rol);

    if($stmt->execute()){
        header("Location: index.php?success=" . urlencode("Usuario creado exitosamente"));
    }else{
        header("Location: create.php?error=" . urlencode("Error al crear el usuario: " . $stmt->error));
    }
    $stmt->close();
    $conn->close();
?>