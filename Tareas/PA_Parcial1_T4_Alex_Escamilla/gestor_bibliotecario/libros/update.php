<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.php");
        exit;
    }

    $id = intval($_POST["id"] ?? 0);
    $titulo = trim($_POST["titulo"] ?? "");
    $isbn = trim($_POST["isbn"] ?? "");
    $anio_publicacion = trim($_POST["anio_publicacion"] ?? "") ?: null;
    $editorial = trim($_POST["editorial"] ?? "");
    $cantidad = intval($_POST["cantidad"] ?? 0);
    $disponibles = intval($_POST["disponibles"] ?? 0);
    $id_categoria = intval($_POST["id_categoria"] ?? 0);
    $id_autores = $_POST["id_autores"] ?? [];

    if ($id <= 0 || $titulo === "" || $id_categoria <= 0 || empty($id_autores)) {
        header("Location: index.php?error=" . urlencode("Datos inválidos"));
        exit;
    }

    // Aquí va el código para actualizar el libro usando una consulta preparada
    $stmt = $conn->prepare("UPDATE libros SET titulo = ?, isbn = ?, anio_publicacion = ?, editorial = ?, cantidad = ?, disponibles = ?, id_categoria = ? WHERE id = ?");
    $stmt->bind_param("ssissiii", $titulo, $isbn, $anio_publicacion, $editorial, $cantidad, $disponibles, $id_categoria, $id);
    if($stmt->execute()){
        header("Location:index.php?success=" . urlencode("Libro actualizado exitosamente"));
        exit;
    }else{
        header("Location: index.php?error=" .urlencode("Error al actualizar el libro: " . $stmt->error));
        exit;
    }

    // Aquí va el código para eliminar los autores actuales del libro usando una consulta preparada
    $stmt = $conn->prepare("DELETE FROM libro_autor WHERE id_libro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    // Aquí va el código para insertar los nuevos autores en libro_autor usando una consulta preparada
    $stmt = $conn->prepare("INSERT INTO libro_autor (id_libro, id_autor) VALUES (?, ?)");
    foreach ($id_autores as $id_autor) {
        $id_autor = intval($id_autor);
        if ($id_autor > 0) {
            $stmt->bind_param("ii", $id, $id_autor);
            $stmt->execute();
        }
    }
?>
