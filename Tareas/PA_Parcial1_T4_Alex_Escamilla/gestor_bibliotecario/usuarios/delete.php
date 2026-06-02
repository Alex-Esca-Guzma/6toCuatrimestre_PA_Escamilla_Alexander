<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    $id = intval($_GET["id"] ?? 0);

    if ($id <= 0) {
        header("Location: index.php?error=" . urlencode("ID inválido"));
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?success=" . urlencode("Usuario eliminado con éxito."));
        exit;
    } else {
        header("Location: index.php?error=" . urlencode("Error al eliminar el usuario: " . $stmt->error));
        exit;
    }
?>
