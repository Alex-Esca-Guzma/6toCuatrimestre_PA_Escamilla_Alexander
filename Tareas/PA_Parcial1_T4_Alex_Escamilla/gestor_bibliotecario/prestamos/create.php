<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    $stmt = $conn->prepare("SELECT id, nombre, apellido FROM usuarios");
    $stmt->execute();
    $usuarios = $stmt->get_result();

    $stmt = $conn->prepare("SELECT id, titulo FROM libros WHERE disponibles > 0");
    $stmt->execute();
    $libros = $stmt->get_result();

    include_once "../includes/header.php";
?>

<div class="page-header">
    <h1><i class="fas fa-plus"></i> Nuevo Prestamo</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <form action="save.php" method="POST">
        <div class="form-group">
            <label><i class="fas fa-user"></i>Usuario</label>
            <select name="id_usuario" required>
                <option value="">Seleccione</option>
                <?php 
                    while($usuario = $usuarios->fetch_assoc()){ 
                        echo "<option value='" . $usuario["id"] . "'>" . $usuario["nombre"] . " " . $usuario["apellido"] . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label><i class="fas fa-book"></i>Libro</label>
            <select name="id_libro" required>
                <option value="">Seleccione</option>
                <?php 
                    while($libro = $libros->fetch_assoc()){
                        echo "<option value='" . $libro["id"] . "'>" . $libro["titulo"] . "</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label><i class="fas fa-calendar-alt"></i>Fecha Préstamo</label>
            <input type="date" name="fecha_prestamo" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-calendar-check"></i>Fecha Devolución</label>
            <input type="date" name="fecha_devolucion" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>

    </form>
</div>

<?php include_once "../includes/footer.php"; ?>