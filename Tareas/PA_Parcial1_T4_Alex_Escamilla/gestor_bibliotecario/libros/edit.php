<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    $id = intval($_GET["id"] ?? 0);

    // Aquí va el código para obtener el libro usando una consulta preparada
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT id, titulo, isbn, anio_publicacion, editorial, cantidad, disponibles, id_categoria FROM libros WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $libro = $resultado->fetch_assoc();
        $stmt->close();
    } else {
        header("Location: index.php?error=" . urlencode("ID inválido"));
        exit;
    }
    // Aquí va el código para obtener los autores asignados al libro usando una consulta preparada
    $stmt = $conn->prepare("SELECT autores.id, autores.nombre, autores.apellido FROM autores INNER JOIN libro_autor ON autores.id = libro_autor.id_autor WHERE libro_autor.id_libro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $autores_asignados = [];
    while($autor = $resultado->fetch_assoc()){
        $autores_asignados[] = $autor;
    }
    $stmt->close();

    // Aquí va el código para obtener todas las categorías usando una consulta preparada
    $stmt = $conn->prepare("SELECT id, nombre FROM categorias ORDER BY nombre");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $categorias = [];
    while($categoria = $resultado->fetch_assoc()){
        $categorias[] = $categoria;
    }
    $stmt->close();

    // Aquí va el código para obtener todos los autores usando una consulta preparada
    $stmt = $conn->prepare("SELECT id, nombre, apellido FROM autores ORDER BY nombre, apellido");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $autores = [];
    while($autor = $resultado->fetch_assoc()){
        $autores[] = $autor;
    }
    $stmt->close();

?>
<?php include_once "../includes/header.php"; ?>

<div class="page-header">
    <h1><i class="fas fa-book-open"></i> Editar Libro</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $libro["id"] ?? $id ?>">

        <div class="form-group">
            <label><i class="fas fa-book"></i> Título</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($libro["titulo"] ?? "") ?>" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-barcode"></i> ISBN</label>
            <input type="text" name="isbn" value="<?= htmlspecialchars($libro["isbn"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label><i class="fas fa-calendar"></i> Año de Publicación</label>
            <input type="number" name="anio_publicacion" value="<?= $libro["anio_publicacion"] ?? "" ?>" min="1000" max="<?= date('Y') ?>">
        </div>

        <div class="form-group">
            <label><i class="fas fa-building"></i> Editorial</label>
            <input type="text" name="editorial" value="<?= htmlspecialchars($libro["editorial"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label><i class="fas fa-cubes"></i> Cantidad</label>
            <input type="number" name="cantidad" value="<?= $libro["cantidad"] ?? 0 ?>" min="0">
        </div>

        <div class="form-group">
            <label><i class="fas fa-check-circle"></i> Disponibles</label>
            <input type="number" name="disponibles" value="<?= $libro["disponibles"] ?? 0 ?>" min="0">
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Categoría</label>
            <select name="id_categoria" required>
                <option value="">-- Selecciona una categoría --</option>
                <?php
                    // Aquí va el código para mostrar las categorías en el <select>
                    $stmt = $conn->prepare("SELECT id, nombre FROM categorias ORDER BY nombre");
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    while($categoria = $resultado->fetch_assoc()){
                        echo "<option value='" . $categoria["id"] . "'>" . htmlspecialchars($categoria["nombre"]) . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label><i class="fas fa-user"></i> Autor(es)</label>
            <select name="id_autores[]" multiple required>
                <?php
                    // Aquí va el código para mostrar los autores en el <select>
                    $stmt = $conn->prepare("SELECT libros.id, libros.titulo, autores.nombre, autores.apellido FROM libros INNER JOIN libro_autor ON libros.id = libro_autor.id_libro INNER JOIN autores ON libro_autor.id_autor = autores.id ORDER BY nombre, apellido");
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    while($autor = $resultado->fetch_assoc()){
                        echo "<option value='" . $autor["id"] . "'>" . htmlspecialchars($autor["nombre"]) . " " . htmlspecialchars($autor["apellido"]) . "</option>";
                    }
                ?>
            </select>
            <small>Mantén Ctrl (o Cmd) para seleccionar varios autores</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<?php include_once "../includes/footer.php"; ?>
