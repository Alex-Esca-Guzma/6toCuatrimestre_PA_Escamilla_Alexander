<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";

    $id = intval($_GET["id"]);

    $stmt = $conn->prepare("SELECT * FROM prestamos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $prestamo = $stmt->get_result()->fetch_assoc();

    include_once "../includes/header.php";
?>

<div class="page-header">
    <h1><i class="fas fa-user-edit"></i> Editar Prestamo</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <form action="update.php" method="POST">

        <input type="hidden" name="id" value="<?= $prestamo["id"] ?>">

        <div class="form-group">
            <label><i class="fas fa-calendar"></i>Fecha Devolución</label>
            <?php
                echo "<input type='date' name='fecha_devolucion' value='" . $prestamo["fecha_devolucion"] . "' required>";
            ?>
        </div>

        <div class="form-group">
            <label><i class="fas fa-info-circle"></i>Estado</label>
            <select name="estado">
                <?php
                    echo "<option value='prestado' " . ($prestamo["estado"] == "prestado" ? "selected" : "") . ">Prestado</option>";
                    echo "<option value='devuelto' " . ($prestamo["estado"] == "devuelto" ? "selected" : "") . ">Devuelto</option>";
                    echo "<option value='retrasado' " . ($prestamo["estado"] == "retrasado" ? "selected" : "") . ">Retrasado</option>";
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>

    </form>
</div>

<?php include_once "../includes/footer.php"; ?>