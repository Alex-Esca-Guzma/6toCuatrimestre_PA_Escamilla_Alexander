<?php
// Modificado por Alex Escamilla

    require_once ("../config/connection.php");
    require_once ("../includes/header.php")
?>

<div class="page-header">
    <h1><i class="fas fa-tags"></i> Usuarios </h1>
    <a href="create.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Nuevo Usuario
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
                <th>Nombre Completo</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Aquí va el código para el select que mostrará las categorías
               $stmt = $conn->prepare("SELECT id, nombre, apellido, telefono, correo FROM usuarios");
               $stmt->execute();
               $resultado=$stmt->get_result();
               while($row=$resultado->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . " " .htmlspecialchars($row["apellido"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["correo"]) . "</td>";
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