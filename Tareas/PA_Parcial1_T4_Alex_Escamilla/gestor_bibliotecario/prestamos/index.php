<?php
// Modificado por Alex Escamilla

    require_once "../config/connection.php";
    include_once "../includes/header.php";
?>

<div class="page-header">
    <h1><i class="fas fa-book-reader"></i> Préstamos</h1>
    <a href="create.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Nuevo Préstamo
    </a>
</div>

<?php if (isset($_GET["success"])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?= htmlspecialchars($_GET["success"]) ?>
    </div>
<?php elseif (isset($_GET["error"])): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <?= htmlspecialchars($_GET["error"]) ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $stmt = $conn->prepare("SELECT p.id, u.nombre, u.apellido, l.titulo, p.fecha_prestamo, p.fecha_devolucion, p.estado FROM prestamos p INNER JOIN usuarios u ON p.id_usuario = u.id INNER JOIN detalle_prestamo d ON p.id = d.id_prestamo INNER JOIN libros l ON d.id_libro = l.id");
                $stmt->execute();
                $resultado = $stmt->get_result();

                while($row = $resultado->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["titulo"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["fecha_prestamo"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["fecha_devolucion"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["estado"]) . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?id=" . urlencode($row["id"]) . "' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i> Editar</a>";
                    echo "<a href='delete.php?id=" . urlencode($row["id"]) . "' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i> Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                $stmt->close();
                $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php include_once "../includes/footer.php"; ?>